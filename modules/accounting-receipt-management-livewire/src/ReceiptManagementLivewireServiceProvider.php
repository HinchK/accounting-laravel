<?php

declare(strict_types=1);

namespace Liberu\Accounting\ReceiptManagementLivewire;

use Illuminate\Support\ServiceProvider;

final class ReceiptManagementLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'module-accounting-receipt-management');
    }
}
