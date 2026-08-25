<?php
declare(strict_types=1);
namespace Liberu\Accounting\SalesInvoicingLivewire;
use Illuminate\Support\ServiceProvider;use Livewire\Livewire;use Liberu\Accounting\SalesInvoicingLivewire\Livewire\Invoices;
final class SalesInvoicingLivewireServiceProvider extends ServiceProvider {public function boot():void{$this->loadViewsFrom(__DIR__.'/../resources/views','accounting-sales-invoicing-livewire');Livewire::component('accounting-sales-invoices',Invoices::class);}}
