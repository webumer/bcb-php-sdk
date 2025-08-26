<?php

namespace Kp\Bcb\Resources;

use GuzzleHttp\Client as Guzzle;
use Kp\Bcb\Auth\OAuthClient;

final class Beneficiaries
{
    public function __construct(private Guzzle $http, private OAuthClient $oauth) {}

    public function list(array $query = []): array
    {
        $res = $this->http->get('/v3/beneficiaries', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
            'query' => $query
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }
}
