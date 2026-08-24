<?php

declare(strict_types=1);

namespace Liberu\AccountingSdk;

final class GeneralLedgerResource
{
    public function __construct(private Client $client) {}

    public function trialBalance(array $query = []): array
    {
        return $this->client->request('GET', 'general-ledger/trial-balance', ['query' => $query]);
    }

    public function balances(array $query = []): array
    {
        return $this->client->request('GET', 'general-ledger/balances', ['query' => $query]);
    }
}
