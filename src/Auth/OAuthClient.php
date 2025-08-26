<?php

namespace Kp\Bcb\Auth;

use GuzzleHttp\Client as Guzzle;

final class OAuthClient
{
    private Guzzle $http;
    private ?string $cachedToken = null;
    private int $expiresAt = 0;

    public function __construct(
        private string $authUrl,
        private string $clientId,
        private string $clientSecret
    ) {
        $this->http = new Guzzle(['timeout' => 15, 'http_errors' => false]);
    }

    public function bearer(): string
    {
        if ($this->cachedToken && time() < $this->expiresAt - 60) {
            return $this->cachedToken;
        }

        $res = $this->http->post($this->authUrl, [
            'headers' => ['accept' => 'application/json'],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'audience' => $this->authUrl
            ],
        ]);

        $data = json_decode((string)$res->getBody(), true) ?: [];
        $token = $data['access_token'] ?? null;
        $expiresIn = (int)($data['expires_in'] ?? 900);

        if (!$token) {
            throw new \RuntimeException('BCB OAuth failed: ' . ((string)$res->getBody()));
        }

        $this->cachedToken = $token;
        $this->expiresAt = time() + $expiresIn;

        return $token;
    }
}
