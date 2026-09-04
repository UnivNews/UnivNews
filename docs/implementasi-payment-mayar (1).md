# Implementasi Sistem Pembayaran (Mayar.id) — UnivNews

## 1. Konteks & Latar Belakang

UnivNews menggunakan model monetisasi **pay-per-publish (one-time)**: author tidak dikenakan biaya saat submit artikel, tetapi wajib membayar satu kali setelah artikel **disetujui admin** dan sebelum artikel benar-benar **dipublikasikan**. Setelah pembayaran berhasil, artikel tayang secara permanen tanpa biaya berulang. Public (pembaca) tidak dikenakan biaya sama sekali.

Payment gateway yang dipilih: **Mayar.id**, karena:
- Didesain untuk individu/kreator, sehingga proses pendaftaran akun **tidak memerlukan badan usaha (PT/CV)** — cukup KTP dan rekening pribadi.
- Sudah mendukung berbagai metode pembayaran dalam satu halaman checkout (QRIS, virtual account bank, e-wallet, kartu).
- Memiliki API + webhook, sehingga proses publish artikel bisa otomatis begitu pembayaran dikonfirmasi.
- Tersedia environment sandbox untuk testing sebelum production.

Alternatif seperti Midtrans/Xendit secara arsitektur mirip, tetapi mengharuskan proses KYC bisnis formal (NIB/NPWP badan usaha) untuk mode production — yang tidak feasible untuk skala proyek ini saat ini.

---

## 2. Environment Mayar.id

| Environment | Dashboard | Base URL API |
|---|---|---|
| Sandbox (testing) | `https://web.mayar.club/` | `https://api.mayar.club/hl/v1/` |
| Production | `https://web.mayar.id/` | `https://api.mayar.id/hl/v1/` |

Kedua environment memiliki API key terpisah. Struktur endpoint & behavior identik — perpindahan dari sandbox ke production cukup dilakukan dengan mengganti base URL dan API key di konfigurasi, tanpa mengubah kode.

**.env**
```env
MAYAR_API_BASE_URL=https://api.mayar.club/hl/v1   # ganti ke api.mayar.id/hl/v1 saat production
MAYAR_API_KEY=xxx_sandbox_key
MAYAR_WEBHOOK_TOKEN=xxx_webhook_verification_token
```

**config/services.php**
```php
'mayar' => [
    'base_url' => env('MAYAR_API_BASE_URL'),
    'api_key' => env('MAYAR_API_KEY'),
    'webhook_token' => env('MAYAR_WEBHOOK_TOKEN'),
],
```

---

## 3. Perubahan Skema Database

### Tabel baru: `payments`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `article_id` | bigint, FK → `articles.id` | Artikel yang akan dipublikasikan |
| `author_id` | bigint, FK → `users.id` | Redundant dari `articles.author_id`, untuk mempermudah query histori pembayaran per author |
| `amount` | decimal(10,2) | Nominal yang harus dibayar, ditentukan backend |
| `status` | enum(`pending`,`paid`,`failed`,`expired`) | |
| `mayar_transaction_id` | string, nullable | ID transaksi dari Mayar, untuk matching webhook |
| `payment_url` | string, nullable | Link checkout yang diberikan Mayar ke author |
| `paid_at` | timestamp, nullable | Diisi saat webhook mengonfirmasi pembayaran sukses |
| `expired_at` | timestamp, nullable | Waktu kedaluwarsa link pembayaran |
| `created_at` / `updated_at` | timestamp | |

**Catatan desain:**
- Relasi `articles` → `payments` bersifat **one-to-many**. Jika author gagal bayar, sistem membuat row baru untuk percobaan berikutnya (bukan update row lama), agar histori kegagalan tetap terlacak dan tidak ada race condition antar percobaan.
- Status pembayaran disimpan terpisah dari `articles.status`, agar histori transaksi tetap konsisten meskipun proses publish gagal di tengah jalan.

### Migration

```php
Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
    $table->decimal('amount', 10, 2);
    $table->enum('status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
    $table->string('mayar_transaction_id')->nullable()->index();
    $table->string('payment_url')->nullable();
    $table->timestamp('paid_at')->nullable();
    $table->timestamp('expired_at')->nullable();
    $table->timestamps();
});
```

---

## 4. Alur Sistem End-to-End

1. Admin meng-approve artikel (status berubah dari `pending_review` menjadi status internal yang menunggu pembayaran, misalnya `awaiting_payment`).
2. Backend menghitung `amount` berdasarkan logika bisnis sendiri (fixed fee atau tier per kategori) — **bukan** dari input yang dikirim client.
3. Backend memanggil `MayarService::createInvoice()`, menyimpan hasilnya sebagai row baru di `payments` dengan status `pending`.
4. Author diarahkan ke `payment_url` dari Mayar, memilih metode pembayaran (QRIS/VA/e-wallet) di halaman checkout Mayar.
5. Setelah author membayar, Mayar mengirim **webhook** ke endpoint backend (`payment.received` atau sejenisnya).
6. Backend memverifikasi keabsahan webhook, mencari row `payments` berdasarkan `mayar_transaction_id`.
7. Dalam satu `DB::transaction()`: update `payments.status` menjadi `paid` + isi `paid_at`, dan update `articles.status` menjadi `published`.
8. Author diarahkan kembali ke halaman "terima kasih" (`redirectUrl`) — halaman ini **hanya tampilan**, bukan pemicu status publish. Status publish sepenuhnya bergantung pada webhook.

**Penting:** Jangan pernah mempublikasikan artikel hanya berdasarkan redirect balik dari Mayar, karena user bisa menutup tab sebelum proses redirect selesai. Sumber kebenaran status pembayaran adalah webhook.

---

## 5. Service Layer — `MayarService`

Semua interaksi ke API Mayar dibungkus dalam satu service class agar tidak tersebar di controller, dan memudahkan migrasi provider di kemudian hari.

```php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class MayarService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.mayar.base_url');
        $this->apiKey = config('services.mayar.api_key');
    }

    public function createInvoice(array $data): array
    {
        $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/invoice", [
                'name'        => $data['name'],
                'email'       => $data['email'],
                'amount'      => $data['amount'],
                'description' => $data['description'],
                'redirectUrl' => $data['redirect_url'],
            ]);

        $response->throw();

        return $response->json();
    }

    public function verifyWebhookSignature(string $signature): bool
    {
        return hash_equals(config('services.mayar.webhook_token'), $signature);
    }
}
```

---

## 6. Endpoint Trigger Pembayaran

```php
// routes/web.php atau api.php
Route::post('/articles/{article}/pay', [PaymentController::class, 'initiate']);
```

```php
public function initiate(Article $article, MayarService $mayar)
{
    // Nominal ditentukan backend, bukan dari request
    $amount = match ($article->category->tier ?? 'reguler') {
        'premium' => 50000,
        default   => 25000,
    };

    $invoice = $mayar->createInvoice([
        'name'         => $article->author->name,
        'email'        => $article->author->email,
        'amount'       => $amount,
        'description'  => "Publish fee - {$article->title}",
        'redirect_url' => route('articles.payment.thanks', $article->id),
    ]);

    $payment = Payment::create([
        'article_id'            => $article->id,
        'author_id'              => $article->author_id,
        'amount'                 => $amount,
        'status'                 => 'pending',
        'mayar_transaction_id'   => $invoice['transaction_id'] ?? null,
        'payment_url'            => $invoice['link'] ?? null,
    ]);

    return redirect($payment->payment_url);
}
```

---

## 7. Webhook Handler

```php
// routes/web.php — pastikan route ini di-exclude dari CSRF middleware (VerifyCsrfToken::class)
Route::post('/webhooks/mayar', [WebhookController::class, 'handleMayar']);
```

```php
public function handleMayar(Request $request, MayarService $mayar)
{
    $signature = $request->header('X-Mayar-Signature');

    if (! $mayar->verifyWebhookSignature($signature)) {
        abort(403);
    }

    $transactionId = $request->input('transaction_id');
    $status = $request->input('status'); // sesuaikan dengan payload asli Mayar

    $payment = Payment::where('mayar_transaction_id', $transactionId)->first();

    if (! $payment) {
        // fallback: matching berdasarkan email jika transaction_id tidak cocok
        // (ID transaksi kadang berbeda antara response createInvoice dan payload webhook)
        return response()->json(['message' => 'Payment record not found'], 404);
    }

    if ($status === 'paid' && $payment->status !== 'paid') {
        DB::transaction(function () use ($payment) {
            $payment->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            $payment->article()->update([
                'status' => 'published',
            ]);
        });
    }

    return response()->json(['message' => 'OK']);
}
```

**Catatan keamanan:**
- Endpoint webhook wajib diverifikasi (signature/token), agar tidak bisa dipicu sembarangan untuk "curang" publish artikel tanpa pembayaran nyata.
- Route webhook harus dikecualikan dari CSRF protection karena request datang dari server Mayar, bukan browser dengan session aktif.

---

## 8. Checklist Implementasi

- [ ] Tambahkan konfigurasi `.env` dan `config/services.php`
- [ ] Buat migration & model `Payment`
- [ ] Buat `MayarService` (createInvoice, verifyWebhookSignature)
- [ ] Buat endpoint trigger pembayaran (`PaymentController@initiate`)
- [ ] Buat endpoint webhook handler, exclude dari CSRF
- [ ] Bungkus update status dalam `DB::transaction()`
- [ ] Buat halaman redirect "terima kasih" (non-fungsional, hanya UI)
- [ ] Uji end-to-end di sandbox: approve → generate invoice → bayar → webhook diterima → artikel published
- [ ] Uji skenario gagal bayar / expired
- [ ] Sebelum production: ganti `MAYAR_API_BASE_URL` & `MAYAR_API_KEY` ke kredensial production

---

## 9. Catatan untuk Fase Berikutnya (Di Luar Scope Dokumen Ini)

- Fitur "panggung utama" (featured placement) adalah fitur tambahan terpisah dari pay-per-publish, dan belum masuk cakupan implementasi ini.
- Kebijakan refund/reuse pembayaran jika artikel ditolak admin setelah pembayaran belum didefinisikan — perlu didiskusikan terpisah.
- Notifikasi email terkait status pembayaran (invoice terbit, pembayaran berhasil, dsb.) bisa memanfaatkan integrasi Resend yang sudah berjalan di sistem notifikasi lain.
