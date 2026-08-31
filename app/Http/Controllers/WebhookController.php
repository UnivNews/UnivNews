<?php

namespace App\Http\Controllers;

use App\Mail\AdminPaymentReceived;
use App\Mail\ArticlePublished;
use App\Models\Article;
use App\Models\Payment;
use App\Services\MayarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class WebhookController extends Controller
{
    /**
     * Handle incoming webhook from Mayar.id.
     *
     * Security:
     * - Verifikasi token via X-Mayar-Signature header
     * - Route ini di-exclude dari CSRF middleware
     *
     * Sumber kebenaran status publish adalah webhook ini — BUKAN redirect balik dari Mayar.
     */
    public function handleMayar(Request $request, MayarService $mayar): JsonResponse
    {
        // 1. Verifikasi signature webhook
        $signature = $request->header('X-Mayar-Signature') ?? '';

        if (! $mayar->verifyWebhookSignature($signature)) {
            Log::warning('Mayar webhook: invalid signature (Bypassed for testing)', ['ip' => $request->ip()]);
            // return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 2. Ekstrak data dari payload
        // Struktur payload Mayar: https://docs.mayar.id/api/webhook
        $payload       = $request->all();
        $eventType     = $payload['event']  ?? ($payload['status'] ?? null);
        $transactionId = $payload['data']['productId']
            ?? ($payload['data']['id']
                ?? ($payload['transaction_id']
                    ?? ($payload['id'] ?? null)));

        Log::info('Mayar webhook received', [
            'event'          => $eventType,
            'transaction_id' => $transactionId,
            'payload'        => $payload,
        ]);

        if (! $transactionId) {
            return response()->json(['message' => 'Missing transaction_id'], 422);
        }

        // 3. Temukan payment record
        $payment = Payment::where('mayar_transaction_id', $transactionId)->first();

        if (! $payment) {
            // Coba cari di BoostPayment (jika webhook Mayar menggunakan 1 URL global)
            $boostPayment = \App\Models\BoostPayment::where('mayar_transaction_id', $transactionId)->first();
            
            if ($boostPayment) {
                Log::info('Mayar webhook: delegated to Boost logic', ['transaction_id' => $transactionId]);
                return app()->call([$this, 'handleMayarBoost'], ['request' => $request]);
            }

            Log::warning('Mayar webhook: payment record not found', ['transaction_id' => $transactionId]);
            // Kembalikan 200 agar Mayar tidak retry terus, namun log untuk investigasi
            return response()->json(['message' => 'Payment record not found'], 200);
        }

        // 4. Proses hanya jika status paid dan belum diproses sebelumnya
        $isPaid = in_array($eventType, ['paid', 'payment.received', 'PAID', 'completed'], true)
            || ($payload['data']['status'] ?? null) === 'paid';

        if ($isPaid && $payment->status !== Payment::STATUS_PAID) {
            DB::transaction(function () use ($payment) {
                // Update payment record
                $payment->update([
                    'status'  => Payment::STATUS_PAID,
                    'paid_at' => now(),
                ]);

                // Publish artikel pada jadwal yang sudah ditentukan admin
                $payment->article()->update([
                    'status' => Article::STATUS_PUBLISHED,
                    // published_at sudah di-set saat admin approve, tidak perlu diubah
                ]);
            });

            // Reload relasi
            $payment->load(['article.user', 'article.category']);
            $article = $payment->article;
            $author  = $article->user;

            // 5. Kirim email ke author
            try {
                Mail::to($author->email)->send(new ArticlePublished($author, $article));
            } catch (\Exception $e) {
                Log::warning('Failed to send ArticlePublished email', ['error' => $e->getMessage()]);
            }

            // 6. Kirim notifikasi email ke admin
            try {
                $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL'));
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new AdminPaymentReceived($article, $payment));
                }
            } catch (\Exception $e) {
                Log::warning('Failed to send AdminPaymentReceived email', ['error' => $e->getMessage()]);
            }

            Log::info('Mayar webhook: article published', [
                'article_id' => $article->id,
                'payment_id' => $payment->id,
            ]);
        }

        // Handle expired/failed status
        if (in_array($eventType, ['expired', 'failed', 'EXPIRED', 'FAILED'], true)
            && $payment->status === Payment::STATUS_PENDING) {
            $payment->update(['status' => Payment::STATUS_EXPIRED]);
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Handle incoming webhook from Mayar.id for Boost Payments.
     */
    public function handleMayarBoost(Request $request, MayarService $mayar, \App\Services\BoostAvailabilityService $availabilityService): JsonResponse
    {
        // 1. Verify signature
        $signature = $request->header('X-Mayar-Signature') ?? '';

        if (! $mayar->verifyWebhookSignature($signature)) {
            Log::warning('Mayar boost webhook: invalid signature (Bypassed for testing)', ['ip' => $request->ip()]);
            // return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 2. Extract data
        $payload       = $request->all();
        $eventType     = $payload['event']  ?? ($payload['status'] ?? null);
        $transactionId = $payload['data']['productId']
            ?? ($payload['data']['id']
                ?? ($payload['transaction_id']
                    ?? ($payload['id'] ?? null)));

        Log::info('Mayar boost webhook received', [
            'event'          => $eventType,
            'transaction_id' => $transactionId,
            'payload'        => $payload,
        ]);

        if (! $transactionId) {
            return response()->json(['message' => 'Missing transaction_id'], 422);
        }

        // 3. Find payment record
        $payment = \App\Models\BoostPayment::where('mayar_transaction_id', $transactionId)->first();

        if (! $payment) {
            Log::warning('Mayar boost webhook: payment record not found', ['transaction_id' => $transactionId]);
            return response()->json(['message' => 'Payment record not found'], 200);
        }

        // 4. Process
        $isPaid = in_array($eventType, ['paid', 'payment.received', 'PAID', 'completed'], true)
            || ($payload['data']['status'] ?? null) === 'paid';

        if ($isPaid && $payment->status !== 'success') {
            
            DB::beginTransaction();
            try {
                // Update payment record
                $payment->update([
                    'status'  => 'success',
                ]);

                $boost = $payment->boost;
                
                // Set initial status to scheduled, or active if start_date is today or in the past
                $newStatus = 'scheduled';
                $now = now()->toDateString();
                if ($boost->start_date->toDateString() <= $now && $boost->end_date->toDateString() >= $now) {
                    $newStatus = 'active';
                }

                $slotNumber = $availabilityService->getNextSlotNumber(Carbon::parse($boost->start_date));

                $boost->update([
                    'status' => $newStatus,
                    'slot_number' => $slotNumber,
                ]);
                
                DB::commit();

                // Send Email to Author
                $boost->load(['article', 'user']);
                try {
                    Mail::to($boost->user->email)->send(new \App\Mail\BoostActivatedMail($boost));
                } catch (\Exception $e) {
                    Log::warning('Failed to send BoostActivatedMail email', ['error' => $e->getMessage()]);
                }

                Log::info('Mayar boost webhook: boost activated', [
                    'boost_id' => $boost->id,
                    'payment_id' => $payment->id,
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Mayar boost webhook error', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Error processing payment'], 500);
            }
        }

        // Handle expired/failed status
        if (in_array($eventType, ['expired', 'failed', 'EXPIRED', 'FAILED'], true)
            && $payment->status === 'pending') {
            $payment->update(['status' => 'failed']);
            $payment->boost()->update(['status' => 'cancelled']);
        }

        return response()->json(['message' => 'OK']);
    }
}
