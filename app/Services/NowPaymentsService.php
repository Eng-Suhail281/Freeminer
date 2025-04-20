<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NowPaymentsService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.nowpayments.io/v1';

    public function __construct()
    {
        $this->apiKey = env('NOWPAYMENTS_API_KEY');

    }

    /**
     * Create a payout (withdraw) request.
     *
     * @param  float   $amount
     * @param  string  $currency  e.g. "TRON", "BNB"
     * @param  string  $address
     * @return array
     */
    public function createPayout(float $amount, string $currency, string $address): array
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->post("{$this->baseUrl}/payout", [
            'amount'  => $amount,
            'currency'=> strtoupper($currency),
            'address' => $address,
        ]);

        return $response->json();
    }
}
