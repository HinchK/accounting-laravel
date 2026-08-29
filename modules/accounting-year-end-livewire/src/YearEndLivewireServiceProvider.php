<?php

declare(strict_types=1);

namespace Liberu\Accounting\YearEndLivewire;

use Illuminate\Support\ServiceProvider;
use Liberu\Accounting\YearEndLivewire\Livewire\YearEndCloses;
use Livewire\Livewire;

final class YearEndLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('accounting-year-end-list', YearEndCloses::class);
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'module-accounting-year-end');
    }
}
