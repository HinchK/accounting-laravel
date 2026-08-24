<?php

namespace Liberu\Accounting\CoreFilament;

use Illuminate\Support\ServiceProvider;

final class AccountingCoreFilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AccountingCoreFilamentPlugin::class);
    }
}
