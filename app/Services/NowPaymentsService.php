<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NowPaymentsService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.nowpayments.io/v1';

    public function __construct()
    {
        $this->apiKey = env('NOWPAYMENTS_API_KEY');
    }


    public function createPayout(float $amount, string $currency, string $address): ?array
{
    $url = rtrim($this->baseUrl, '/') . '/payout';
    $payload = [
        'payout_address' => $address,
        'payout_currency' => $currency,
        'amount' => $amount,
    ];

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post($url, $payload);

        $response->throw();

        return $response->json();
    } catch (\Exception $e) {
        Log::error('NowPayments Payout Error', [
            'method'  => 'createPayout',
            'error'   => $e->getMessage(),
            'payload' => $payload,
        ]);
        return null;
    }
}

}
