<?php

namespace Kp\Bcb\Resources;

final class Webhooks
{
    /**
     * Parse virtual account creation/update webhook payload
     * Returns a normalized array with status and key fields.
     */
    public function parseVirtualAccountEvent(array $payload): array
    {
        $result = [
            'type' => 'virtual_account',
            'status' => null,
            'correlation_id' => $payload['correlation_id'] ?? null,
            'account_details' => $payload['account_details'] ?? null,
            'request_details' => $payload['request_details'] ?? null,
            'failure_reason' => $payload['failure_reason'] ?? null,
        ];

        if (isset($payload['failure_reason'])) {
            $result['status'] = 'failed';
        } elseif (isset($payload['account_details'])) {
            $result['status'] = 'active';
        }

        return $result;
    }

    /**
     * Parse transactions batch webhook payload
     * Normalizes deposit/withdraw records for a virtual account.
     */
    public function parseTransactionsEvent(array $payload): array
    {
        $items = $payload['transactions'] ?? [];
        $normalized = [];
        foreach ($items as $tx) {
            if (!isset($tx['virtual_account_iban'])) {
                continue;
            }
            $normalized[] = [
                'transaction_id' => $tx['id'] ?? null,
                'timestamp' => $tx['timestamp'] ?? null,
                'amount_instructed' => $tx['amount_instructed'] ?? null,
                'amount' => $tx['amount_actual'] ?? null,
                'currency' => $tx['currency'] ?? null,
                'credit' => $tx['credit'] ?? null,
                'reference' => $tx['reference'] ?? null,
                'bank_name' => $tx['bank_name'] ?? null,
                'bank_country' => $tx['bank_country'] ?? null,
                'account_name' => $tx['account_name'] ?? null,
                'account_address' => $tx['account_address'] ?? null,
                'notes_external' => $tx['notes_external'] ?? null,
                'virtual_account_iban' => $tx['virtual_account_iban'] ?? null,
                'from' => $tx['from'] ?? null,
                'account_number' => $tx['account_number'] ?? null,
                'sort_code' => $tx['sort_code'] ?? null,
                'iban' => $tx['iban'] ?? null,
                'status' => $tx['status'] ?? 'completed',
            ];
        }

        return [
            'type' => 'transactions',
            'items' => $normalized,
        ];
    }
}


