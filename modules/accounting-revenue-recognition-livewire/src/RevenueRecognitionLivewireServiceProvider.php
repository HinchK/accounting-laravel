<?php
declare(strict_types=1);
namespace Liberu\Accounting\RevenueRecognitionLivewire;
use Illuminate\Support\ServiceProvider;
final class RevenueRecognitionLivewireServiceProvider extends ServiceProvider {public function boot():void{$this->loadViewsFrom(__DIR__.'/../resources/views','module-accounting-revenue-recognition');}}
