<?php

namespace Webumer\Bcb\Resources;

use GuzzleHttp\Client as Guzzle;
use Webumer\Bcb\Auth\OAuthClient;

final class Viban
{
    public function __construct(private Guzzle $http, private OAuthClient $oauth, private string $clientBaseUrl) {}

    /**
     * Create virtual account
     */
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

    /**
     * Update virtual account owner SWIFT details (IBAN/BIC)
     */
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

    /**
     * Update virtual account owner account details (account/sort code)
     */
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

    /**
     * Get all virtual accounts for an account
     */
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

    /**
     * Initiate payment from virtual account (internal transfer)
     */
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

    /**
     * Get single virtual account details
     */
    public function get(string $accountId, string $iban): array
    {
        $res = $this->http->get($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Get virtual account transactions
     */
    public function getTransactions(string $accountId, string $iban, array $query = []): array
    {
        $res = $this->http->get($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/transactions", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
            'query' => $query,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Get virtual account balance
     */
    public function getBalance(string $accountId, string $iban): array
    {
        $res = $this->http->get($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/balance", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Update virtual account status (enable/disable)
     */
    public function updateStatus(string $accountId, string $iban, array $payload): array
    {
        $res = $this->http->put($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/status", [
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
     * Close virtual account (recommended method)
     */
    public function close(string $accountId, string $iban): array
    {
        $res = $this->http->post($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/close", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => [],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Delete/close virtual account (legacy method - may not work)
     */
    public function delete(string $accountId, string $iban): array
    {
        $res = $this->http->delete($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Get virtual account statements
     */
    public function getStatements(string $accountId, string $iban, array $query = []): array
    {
        $res = $this->http->get($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/statements", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
            'query' => $query,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Create beneficiary from virtual account
     */
    public function createBeneficiary(string $accountId, string $iban, array $payload): array
    {
        $res = $this->http->post($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/beneficiaries", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    // Note: BCB API does not currently provide webhook management endpoints
    // Webhook configuration must be done through BCB support team
    // These methods have been removed as they don't exist in the actual BCB API

    /**
     * Get virtual account limits
     */
    public function getLimits(string $accountId, string $iban): array
    {
        $res = $this->http->get($this->clientBaseUrl . "/v1/accounts/{$accountId}/virtual/{$iban}/limits", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }
}
