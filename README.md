# BCB PHP SDK

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/packagist/php-v/webumer/bcb-php-sdk)](https://packagist.org/packages/webumer/bcb-php-sdk)

Unofficial PHP SDK for BCB Group Client API. Provides easy integration for payments, beneficiaries, virtual IBANs, and webhooks.

## Features

- 🔐 OAuth2 client credentials authentication with token caching
- 💳 Payment initiation and status checking
- 👥 Beneficiary management (regular and BLINC)
- 🏦 Virtual IBAN creation and management
- 📡 Webhook event parsing helpers
- 🚀 Framework-agnostic (works with Laravel, Symfony, or vanilla PHP)

## Installation

```bash
composer require webumer/bcb-php-sdk
```

## Quick Start

```php
use Webumer\Bcb\BcbClient;

$client = new BcbClient(
    baseUrl: 'https://api.bcb.group',
    authUrl: 'https://auth.bcb.group', 
    clientBaseUrl: 'https://client-api.bcb.group',
    clientId: 'your_client_id',
    clientSecret: 'your_client_secret'
);

// List beneficiaries
$beneficiaries = $client->beneficiaries()->list();

// Create virtual IBAN
$viban = $client->viban()->create($accountId, [
    'correlationId' => 'unique-id',
    'name' => 'John Doe',
    'isIndividual' => true,
    // ... other fields
]);

// Initiate payment
$payment = $client->payments()->authorise([
    'counterparty_id' => 'counterparty-id',
    'beneficiary_account_id' => 'beneficiary-id', 
    'ccy' => 'GBP',
    'amount' => '100.00',
    'reference' => 'Invoice 123',
    'preferred_scheme' => 'AUTO'
]);

// Parse webhook events
$webhook = $client->webhooks()->parseVirtualAccountEvent($payload);
```

## API Coverage

### Payments
- `authorise()` - Initiate payment
- `get()` - Get payment status

### Beneficiaries  
- `list()` - List beneficiaries

### Virtual IBANs
- `create()` - Create virtual account
- `updateOwnerSwiftDetails()` - Update IBAN/BIC
- `updateOwnerAccountDetails()` - Update account/sort code
- `getAll()` - List all virtual accounts
- `initiatePayment()` - Internal transfer

### Webhooks
- `parseVirtualAccountEvent()` - Parse account creation/failure
- `parseTransactionsEvent()` - Parse transaction batches

## Requirements

- PHP 8.1+
- Guzzle HTTP 7.8+

## License

MIT License. See [LICENSE](LICENSE) file.

## Disclaimer

This is an unofficial SDK. BCB Group is not affiliated with this project.

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Support

- GitHub Issues: [Report bugs or request features](https://github.com/webumer/bcb-php-sdk/issues)
- BCB Group API Docs: [client-api.bcb.group](https://client-api.bcb.group/docs)