<?php

declare(strict_types=1);

namespace Liberu\Accounting\SupplierPortalLivewire;

use Illuminate\Support\ServiceProvider;

final class SupplierPortalLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'module-accounting-supplier-portal');
    }
}
