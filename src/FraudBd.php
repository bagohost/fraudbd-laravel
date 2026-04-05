<?php

namespace FraudBd\Laravel;

use Illuminate\Support\Facades\Http;

class FraudBd
{
    protected function getHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'RKR-API-KEY' => config('fraudbd.api_key'),
            'RKR-SECRET-KEY' => config('fraudbd.secret_key'),
        ];
    }

    // Trust Score Verification
    public function verifyFraudScore($phone)
    {
        $url = config('fraudbd.base_url') . '/search';

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->withoutVerifying()
                ->post($url, ['phone' => $phone]);

            return $response->json();
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // Trust Score Calibration (Crowdsourcing / Sync)
    public function calibrateTrustScore($phone, $status, $orderId = null, $source = null)
    {
        $url = config('fraudbd.base_url') . '/sync-data';
        $domain = $source ?? request()->getHost();

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->withoutVerifying()
                ->post($url, [
                    'records' => [
                        [
                            'phone' => $phone,
                            'source' => $domain,
                            'tracking_id' => (string) $orderId,
                            'status' => strtolower($status)
                        ]
                    ]
                ]);

            return $response->json();
        } catch (\Exception $e) {
            return null;
        }
    }
}