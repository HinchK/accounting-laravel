<?php
declare(strict_types=1);
namespace Liberu\Accounting\TaxCoreLivewire;
use Illuminate\Support\ServiceProvider;
final class TaxCoreLivewireServiceProvider extends ServiceProvider { public function boot(): void { $this->loadViewsFrom(__DIR__.'/../resources/views','module-accounting-tax-core'); $this->loadViewsFrom(__DIR__.'/../resources/views','accounting-tax-core'); } }
