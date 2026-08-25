<?php
declare(strict_types=1);
namespace Liberu\Accounting\ReimbursementsLivewire;
use Illuminate\Support\ServiceProvider;
final class ReimbursementsLivewireServiceProvider extends ServiceProvider {public function boot():void{$this->loadViewsFrom(__DIR__.'/../resources/views','module-accounting-reimbursements');}}
