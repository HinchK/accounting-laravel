<?php
declare(strict_types=1);
namespace Liberu\Accounting\PurchaseRequisitionsLivewire;
use Illuminate\Support\ServiceProvider;
final class PurchaseRequisitionsLivewireServiceProvider extends ServiceProvider {public function boot():void{$this->loadViewsFrom(__DIR__.'/../resources/views','module-accounting-purchase-requisitions');}}
