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

### Using Environment Configuration (Recommended)

```php
use Webumer\Bcb\BcbClient;
use Webumer\Bcb\BcbEnvironment;

// For UAT/Sandbox environment
$client = BcbClient::forEnvironment(
    environment: BcbEnvironment::UAT,
    clientId: 'your_client_id',
    clientSecret: 'your_client_secret'
);

// For Production environment
$client = BcbClient::forEnvironment(
    environment: BcbEnvironment::PRODUCTION,
    clientId: 'your_client_id',
    clientSecret: 'your_client_secret'
);
```

### Manual Configuration

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

// Get virtual account details
$account = $client->viban()->get($accountId, $iban);

// Get virtual account balance
$balance = $client->viban()->getBalance($accountId, $iban);

// Get transaction history
$transactions = $client->viban()->getTransactions($accountId, $iban, [
    'from' => '2024-01-01',
    'to' => '2024-12-31'
]);

// Create beneficiary
$beneficiary = $client->beneficiaries()->create([
    'name' => 'John Doe',
    'account_number' => '12345678',
    'sort_code' => '123456',
    'currency' => 'GBP'
]);

// List payments
$payments = $client->payments()->list(['status' => 'completed']);

// Cancel payment
$result = $client->payments()->cancel($paymentId);
```

## API Coverage

### Payments
- `authorise()` - Initiate payment
- `get()` - Get payment details
- `list()` - List payments with filters
- `cancel()` - Cancel payment
- `getStatus()` - Get payment status

### Beneficiaries  
- `list()` - List beneficiaries
- `create()` - Create new beneficiary
- `get()` - Get beneficiary details
- `update()` - Update beneficiary
- `delete()` - Delete beneficiary
- `validate()` - Validate beneficiary details

### Virtual IBANs
- `create()` - Create virtual account
- `get()` - Get single virtual account details
- `getAll()` - List all virtual accounts
- `updateOwnerSwiftDetails()` - Update IBAN/BIC
- `updateOwnerAccountDetails()` - Update account/sort code
- `updateStatus()` - Enable/disable virtual account
- `delete()` - Close/delete virtual account
- `getTransactions()` - Get transaction history
- `getBalance()` - Get account balance
- `getStatements()` - Get account statements
- `getLimits()` - Get transaction limits
- `createBeneficiary()` - Create beneficiary from vIBAN
- `initiatePayment()` - Internal transfer

**Note**: Webhook configuration is not available at virtual IBAN level in BCB API. Webhooks must be configured through BCB support.

### Accounts
- `get()` - Get account details
- `list()` - List all accounts
- `balance()` - Get account balance
- `getTransactions()` - Get account transactions
- `getStatements()` - Get account statements

### Webhooks
- `parseVirtualAccountEvent()` - Parse account creation/failure
- `parseTransactionsEvent()` - Parse transaction batches

## Environments

The SDK supports two environments:

### UAT/Sandbox Environment
- **Auth URL**: `https://auth.uat.bcb.group/oauth/token`
- **API URL**: `https://api.uat.bcb.group`
- **Client URL**: `https://client-api.uat.bcb.group`
- **API Version**: `v3` (for payments, beneficiaries, accounts)
- **Client API Version**: `v1` (for virtual IBANs)
- **Use for**: Testing and development

### Production Environment
- **Auth URL**: `https://auth.bcb.group/oauth/token`
- **API URL**: `https://api.bcb.group`
- **Client URL**: `https://client-api.bcb.group`
- **API Version**: `v3` (for payments, beneficiaries, accounts)
- **Client API Version**: `v1` (for virtual IBANs)
- **Use for**: Live production applications

### Environment Usage

```php
// UAT Environment
$uatClient = BcbClient::forEnvironment(
    environment: BcbEnvironment::UAT,
    clientId: 'your_uat_client_id',
    clientSecret: 'your_uat_client_secret'
);

// Production Environment
$prodClient = BcbClient::forEnvironment(
    environment: BcbEnvironment::PRODUCTION,
    clientId: 'your_prod_client_id',
    clientSecret: 'your_prod_client_secret'
);
```

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