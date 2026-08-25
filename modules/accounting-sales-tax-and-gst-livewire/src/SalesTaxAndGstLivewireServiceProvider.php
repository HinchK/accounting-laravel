<?php
declare(strict_types=1);
namespace Liberu\Accounting\SalesTaxAndGstLivewire;
use Illuminate\Support\ServiceProvider;final class SalesTaxAndGstLivewireServiceProvider extends ServiceProvider {public function boot():void{$this->loadViewsFrom(__DIR__.'/../resources/views','module-accounting-sales-tax-and-gst');}}
