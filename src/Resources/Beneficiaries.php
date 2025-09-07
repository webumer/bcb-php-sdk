<?php

namespace Webumer\Bcb\Resources;

use GuzzleHttp\Client as Guzzle;
use Webumer\Bcb\Auth\OAuthClient;

final class Beneficiaries
{
    public function __construct(private Guzzle $http, private OAuthClient $oauth) {}

    /**
     * List beneficiaries with optional filters
     */
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

    /**
     * Create new beneficiary
     */
    public function create(array $payload): array
    {
        $res = $this->http->post('/v3/beneficiaries', [
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
     * Get beneficiary details
     */
    public function get(string $beneficiaryId): array
    {
        $res = $this->http->get("/v3/beneficiaries/{$beneficiaryId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Update beneficiary
     */
    public function update(string $beneficiaryId, array $payload): array
    {
        $res = $this->http->put("/v3/beneficiaries/{$beneficiaryId}", [
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
     * Delete beneficiary
     */
    public function delete(string $beneficiaryId): array
    {
        $res = $this->http->delete("/v3/beneficiaries/{$beneficiaryId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Validate beneficiary details
     */
    public function validate(array $payload): array
    {
        $res = $this->http->post('/v3/beneficiaries/validate', [
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
     * List BLINC beneficiaries
     */
    public function listBlinc(array $query = []): array
    {
        $res = $this->http->get('/v3/blinc-beneficiaries', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
            'query' => $query
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Retrieve BLINC account information by BLINC ID
     */
    public function getBlincAccount(string $blincId): array
    {
        $res = $this->http->get("/v3/blinc-beneficiaries/{$blincId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->oauth->bearer(),
                'Accept' => 'application/json',
            ],
        ]);
        return json_decode((string)$res->getBody(), true) ?: [];
    }

    /**
     * Create BLINC beneficiary
     */
    public function createBlinc(array $payload): array
    {
        $res = $this->http->post('/v3/blinc-beneficiaries', [
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
