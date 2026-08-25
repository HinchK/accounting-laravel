<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayableLivewire\Livewire;

use Illuminate\Auth\Access\AuthorizationException;
use Liberu\Accounting\AccountsPayable\Queries\SupplierSubledgerQuery;
use Livewire\Component;

final class Payables extends Component
{
    public int $partyId;

    public function mount(int $partyId): void
    {
        if (! auth()->check()) {
            throw new AuthorizationException('Authentication is required to view payables.');
        }
        $this->partyId = $partyId;
    }

    public function render(): mixed
    {
        return view('accounting-accounts-payable::payables', ['ledger' => app(SupplierSubledgerQuery::class)->handle($this->partyId)]);
    }
}
