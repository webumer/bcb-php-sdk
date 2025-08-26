<?php

namespace Kp\Bcb\Resources;

use GuzzleHttp\Client as Guzzle;
use Kp\Bcb\Auth\OAuthClient;

final class Viban
{
    public function __construct(private Guzzle $http, private OAuthClient $oauth, private string $clientBaseUrl) {}

    public function create(string $accountId, array $payload): array
    {
        $res = $this->http->post($this->clientBaseUrl . "/v2/accounts/{$accountId}/virtual", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => [$payload],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    public function updateOwnerSwiftDetails(string $accountId, string $iban, array $payload): array
    {
        $res = $this->http->put($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/owner-bank-details", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    public function updateOwnerAccountDetails(string $accountId, string $iban, array $payload): array
    {
        $res = $this->http->put($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/owner-bank-details", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    public function getAll(string $accountId): array
    {
        $res = $this->http->get($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/all-account-data", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    public function initiatePayment(string $accountId, string $iban, array $payload): array
    {
        $res = $this->http->post($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/payment", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }
}
