<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayableApi;

use Illuminate\Support\ServiceProvider;

final class AccountsPayableApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}
