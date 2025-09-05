<?php

require_once 'vendor/autoload.php';

use Webumer\Bcb\BcbClient;
use Webumer\Bcb\BcbEnvironment;

echo "=== BCB SDK Environment Test ===\n\n";

// Test UAT Environment
echo "1. Testing UAT Environment Configuration:\n";
$uatUrls = BcbEnvironment::getUrls(BcbEnvironment::UAT);
echo "Auth URL: " . $uatUrls['auth_url'] . "\n";
echo "API URL: " . $uatUrls['api_url'] . "\n";
echo "Client URL: " . $uatUrls['client_url'] . "\n\n";

// Test Production Environment
echo "2. Testing Production Environment Configuration:\n";
$prodUrls = BcbEnvironment::getUrls(BcbEnvironment::PRODUCTION);
echo "Auth URL: " . $prodUrls['auth_url'] . "\n";
echo "API URL: " . $prodUrls['api_url'] . "\n";
echo "Client URL: " . $prodUrls['client_url'] . "\n\n";

// Test Factory Method
echo "3. Testing Factory Method:\n";
try {
    $uatClient = BcbClient::forEnvironment(
        environment: BcbEnvironment::UAT,
        clientId: 'test_client_id',
        clientSecret: 'test_client_secret'
    );
    echo "✅ UAT Client created successfully\n";
    
    $prodClient = BcbClient::forEnvironment(
        environment: BcbEnvironment::PRODUCTION,
        clientId: 'test_client_id',
        clientSecret: 'test_client_secret'
    );
    echo "✅ Production Client created successfully\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
