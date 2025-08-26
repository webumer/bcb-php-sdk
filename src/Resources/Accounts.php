<?php

namespace Webumer\Bcb\Resources;

use GuzzleHttp\Client as Guzzle;
use Webumer\Bcb\Auth\OAuthClient;

final class Accounts
{
    public function __construct(private Guzzle $http, private OAuthClient $oauth) {}

    /**
     * Get account balance
     */
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

    /**
     * Get account details
     */
    public function get(string $accountId): array
    {
        $res = $this->http->get("/v3/accounts/{$accountId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ]
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * List all accounts
     */
    public function list(array $query = []): array
    {
        $res = $this->http->get('/v3/accounts', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
            'query' => $query,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Get account transactions
     */
    public function getTransactions(string $accountId, array $query = []): array
    {
        $res = $this->http->get("/v3/accounts/{$accountId}/transactions", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
            'query' => $query,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Get account statements
     */
    public function getStatements(string $accountId, array $query = []): array
    {
        $res = $this->http->get("/v3/accounts/{$accountId}/statements", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
            'query' => $query,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }
}
