<?php

declare(strict_types=1);

namespace Liberu\Accounting\FinancialMasterDataLivewire;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Liberu\Accounting\FinancialMasterDataLivewire\Livewire\Parties;
use Liberu\Accounting\FinancialMasterDataLivewire\Livewire\ReferenceData;

final class FinancialMasterDataLivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'accounting-financial-master-data-livewire');
        Livewire::component('module-accounting-financial-master-data-parties', Parties::class);
        Livewire::component('module-accounting-financial-master-data::parties', Parties::class);
        Livewire::component('module-accounting-financial-master-data-reference-data', ReferenceData::class);
        Livewire::component('module-accounting-financial-master-data::reference-data', ReferenceData::class);
    }
}
