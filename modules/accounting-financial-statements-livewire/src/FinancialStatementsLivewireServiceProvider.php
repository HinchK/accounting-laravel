<?php
declare(strict_types=1);
namespace Liberu\Accounting\FinancialStatementsLivewire;
use Illuminate\Support\ServiceProvider; use Livewire\Livewire; use Liberu\Accounting\FinancialStatementsLivewire\Livewire\Statements;
final class FinancialStatementsLivewireServiceProvider extends ServiceProvider { public function boot():void{Livewire::component('accounting-financial-statements',Statements::class);} }
