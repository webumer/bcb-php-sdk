<?php

namespace Kp\Bcb;

use GuzzleHttp\Client as Guzzle;
use Kp\Bcb\Auth\OAuthClient;
use Kp\Bcb\Resources\Payments;
use Kp\Bcb\Resources\Beneficiaries;
use Kp\Bcb\Resources\Accounts;
use Kp\Bcb\Resources\Viban;
use Kp\Bcb\Resources\Webhooks;

final class BcbClient
{
    private Guzzle $http;
    private OAuthClient $oauth;
    private string $clientBaseUrl;

    public function __construct(
        string $baseUrl,
        string $authUrl,
        string $clientBaseUrl,
        string $clientId,
        string $clientSecret,
        array $httpOptions = []
    ) {
        $this->http = new Guzzle(array_merge([
            'base_uri' => rtrim($baseUrl, '/'),
            'timeout' => 30,
            'http_errors' => false,
            'verify' => env('APP_ENV') === 'local' ? false : true
        ], $httpOptions));

        $this->oauth = new OAuthClient($authUrl, $clientId, $clientSecret);
        $this->clientBaseUrl = rtrim($clientBaseUrl, '/');
    }

    public function payments(): Payments { return new Payments($this->http, $this->oauth); }
    public function beneficiaries(): Beneficiaries { return new Beneficiaries($this->http, $this->oauth); }
    public function accounts(): Accounts { return new Accounts($this->http, $this->oauth); }
    public function viban(): Viban { return new Viban($this->http, $this->oauth, $this->clientBaseUrl); }
    public function webhooks(): Webhooks { return new Webhooks(); }
}
