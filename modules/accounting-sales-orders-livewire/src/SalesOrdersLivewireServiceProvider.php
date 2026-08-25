<?php

declare(strict_types=1);

namespace Liberu\Accounting\SalesOrdersLivewire;

use Illuminate\Support\ServiceProvider;

final class SalesOrdersLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'module-accounting-sales-orders');
    }
}
