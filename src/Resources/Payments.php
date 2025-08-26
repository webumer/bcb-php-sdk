<?php

namespace Webumer\Bcb\Resources;

use GuzzleHttp\Client as Guzzle;
use Webumer\Bcb\Auth\OAuthClient;

final class Payments
{
    public function __construct(private Guzzle $http, private OAuthClient $oauth) {}

    /**
     * Authorise/initiate payment
     */
    public function authorise(array $payload): array
    {
        $res = $this->http->post('/v3/payments/authorise', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Get payment details
     */
    public function get(string $paymentId): array
    {
        $res = $this->http->get("/v3/payments/{$paymentId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * List payments with optional filters
     */
    public function list(array $query = []): array
    {
        $res = $this->http->get('/v3/payments', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
            'query' => $query,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Cancel payment
     */
    public function cancel(string $paymentId): array
    {
        $res = $this->http->post("/v3/payments/{$paymentId}/cancel", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Get payment status
     */
    public function getStatus(string $paymentId): array
    {
        $res = $this->http->get("/v3/payments/{$paymentId}/status", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }
}
