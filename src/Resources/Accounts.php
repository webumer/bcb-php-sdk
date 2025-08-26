<?php

namespace Webumer\Bcb\Resources;

use GuzzleHttp\Client as Guzzle;
use Webumer\Bcb\Auth\OAuthClient;

final class Accounts
{
    public function __construct(private Guzzle $http, private OAuthClient $oauth) {}

    public function balance(string $accountId): array
    {
        $res = $this->http->get("/v3/accounts/{$accountId}/balance", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ]
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }
}
