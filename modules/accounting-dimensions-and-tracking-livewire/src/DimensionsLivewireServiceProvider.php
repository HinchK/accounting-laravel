<?php
declare(strict_types=1);
namespace Liberu\Accounting\DimensionsLivewire;
use Illuminate\Support\ServiceProvider; use Livewire\Livewire; use Liberu\Accounting\DimensionsLivewire\Livewire\Dimensions;
final class DimensionsLivewireServiceProvider extends ServiceProvider { public function boot():void{Livewire::component('module-accounting-dimensions-and-tracking::dimensions',Dimensions::class);Livewire::component('accounting-dimensions',Dimensions::class);} }
