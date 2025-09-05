<?php

namespace Webumer\Bcb;

class BcbEnvironment
{
    public const UAT = 'uat';
    public const PRODUCTION = 'production';
    
    private static array $environments = [
        self::UAT => [
            'auth_url' => 'https://auth.uat.bcb.group/oauth/token',
            'api_url' => 'https://api.uat.bcb.group',
            'client_url' => 'https://client-api.uat.bcb.group',
            'api_version' => 'v3',
            'client_api_version' => 'v1',
        ],
        self::PRODUCTION => [
            'auth_url' => 'https://auth.bcb.group/oauth/token',
            'api_url' => 'https://api.bcb.group',
            'client_url' => 'https://client-api.bcb.group',
            'api_version' => 'v3',
            'client_api_version' => 'v1',
        ],
    ];
    
    public static function getUrls(string $environment): array
    {
        if (!isset(self::$environments[$environment])) {
            throw new \InvalidArgumentException("Unknown environment: {$environment}");
        }
        
        return self::$environments[$environment];
    }
    
    public static function getAuthUrl(string $environment): string
    {
        return self::getUrls($environment)['auth_url'];
    }
    
    public static function getApiUrl(string $environment): string
    {
        return self::getUrls($environment)['api_url'];
    }
    
    public static function getClientUrl(string $environment): string
    {
        return self::getUrls($environment)['client_url'];
    }
    
    public static function getApiVersion(string $environment): string
    {
        return self::getUrls($environment)['api_version'];
    }
    
    public static function getClientApiVersion(string $environment): string
    {
        return self::getUrls($environment)['client_api_version'];
    }
    
    public static function getAvailableEnvironments(): array
    {
        return array_keys(self::$environments);
    }
}
