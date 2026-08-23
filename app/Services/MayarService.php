<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class MayarService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.mayar.base_url'), '/');
        $this->apiKey  = config('services.mayar.api_key');
    }

    /**
     * Create a payment invoice at Mayar.id.
     *
     * @param  array{
     *   name: string,
     *   email: string,
     *   amount: int,
     *   description: string,
     *   redirect_url: string,
     *   mobile: string
     * } $data
     * @return array  Raw JSON response from Mayar
     * @throws RequestException
     */
    public function createInvoice(array $data): array
    {
        $response = Http::withToken($this->apiKey)
            ->timeout(30)
            ->post("{$this->baseUrl}/invoice/create", [
                'name'        => $data['name'],
                'email'       => $data['email'],
                'amount'      => $data['amount'],
                'description' => $data['description'],
                'redirectUrl' => $data['redirect_url'],
                'mobile'      => $data['mobile'] ?? '000000000000',
                'items'       => [
                    [
                        'name'        => 'Biaya Publish',
                        'description' => $data['description'],
                        'quantity'    => 1,
                        'rate'        => $data['amount']
                    ]
                ]
            ]);

        $response->throw();

        return $response->json();
    }

    /**
     * Verify the webhook token sent by Mayar in the X-Mayar-Signature header.
     */
    public function verifyWebhookSignature(string $signature): bool
    {
        $token = config('services.mayar.webhook_token');

        if (empty($token)) {
            return false;
        }

        return hash_equals($token, $signature);
    }
}
