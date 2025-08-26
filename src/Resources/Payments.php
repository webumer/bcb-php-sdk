<?php

namespace Webumer\Bcb\Resources;

use GuzzleHttp\Client as Guzzle;
use Webumer\Bcb\Auth\OAuthClient;

final class Payments
{
    public function __construct(private Guzzle $http, private OAuthClient $oauth) {}

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
}
