<?php

namespace Webumer\Bcb;

use GuzzleHttp\Client as Guzzle;
use Webumer\Bcb\Auth\OAuthClient;
use Webumer\Bcb\Resources\Payments;
use Webumer\Bcb\Resources\Beneficiaries;
use Webumer\Bcb\Resources\Accounts;
use Webumer\Bcb\Resources\Viban;
use Webumer\Bcb\Resources\Webhooks;

final class BcbClient
{
    private Guzzle $http;
    private OAuthClient $oauth;
    private string $clientBaseUrl;
    private string $apiVersion;
    private string $clientApiVersion;

    public function __construct(
        string $baseUrl,
        string $authUrl,
        string $clientBaseUrl,
        string $clientId,
        string $clientSecret,
        string $apiVersion = 'v3',
        string $clientApiVersion = 'v1',
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
        $this->apiVersion = $apiVersion;
        $this->clientApiVersion = $clientApiVersion;
    }

    /**
     * Create a BCB client for a specific environment
     */
    public static function forEnvironment(
        string $environment,
        string $clientId,
        string $clientSecret,
        array $httpOptions = []
    ): self {
        $urls = BcbEnvironment::getUrls($environment);
        
        return new self(
            $urls['api_url'],
            $urls['auth_url'],
            $urls['client_url'],
            $clientId,
            $clientSecret,
            $urls['api_version'],
            $urls['client_api_version'],
            $httpOptions
        );
    }

    public function payments(): Payments { return new Payments($this->http, $this->oauth, $this->apiVersion); }
    public function beneficiaries(): Beneficiaries { return new Beneficiaries($this->http, $this->oauth, $this->apiVersion); }
    public function accounts(): Accounts { return new Accounts($this->http, $this->oauth, $this->apiVersion); }
    public function viban(): Viban { return new Viban($this->http, $this->oauth, $this->clientBaseUrl, $this->clientApiVersion); }
    public function webhooks(): Webhooks { return new Webhooks(); }
}
