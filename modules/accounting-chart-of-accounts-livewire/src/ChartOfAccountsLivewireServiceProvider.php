<?php

declare(strict_types=1);

namespace Liberu\Accounting\ChartOfAccountsLivewire;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Liberu\Accounting\ChartOfAccountsLivewire\Livewire\Accounts;

final class ChartOfAccountsLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'accounting-chart-of-accounts-livewire');
        Livewire::component('module-accounting-chart-of-accounts-accounts', Accounts::class);
        Livewire::component('module-accounting-chart-of-accounts::accounts', Accounts::class);
    }
}
