<?php

declare(strict_types=1);

namespace Liberu\Accounting\RecurringTransactionsLivewire;

use Illuminate\Support\ServiceProvider;

final class RecurringTransactionsLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'module-accounting-recurring-transactions');
    }
}
