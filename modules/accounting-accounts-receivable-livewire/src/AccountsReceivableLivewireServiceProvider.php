<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsReceivableLivewire;

use Illuminate\Support\ServiceProvider;
use Liberu\Accounting\AccountsReceivableLivewire\Livewire\Receivables;
use Livewire\Livewire;

class AccountsReceivableLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'accounting-accounts-receivable');
        Livewire::component('module-accounting-accounts-receivable::receivables', Receivables::class);
        Livewire::component('accounting-accounts-receivables', Receivables::class);
    }
}
