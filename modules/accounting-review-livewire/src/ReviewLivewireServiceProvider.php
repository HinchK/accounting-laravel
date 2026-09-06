<?php
declare(strict_types=1);
namespace Liberu\Accounting\ReviewLivewire;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Liberu\Accounting\ReviewLivewire\Livewire\ReviewItems;
final class ReviewLivewireServiceProvider extends ServiceProvider { public function boot(): void { $this->loadViewsFrom(__DIR__.'/../resources/views','accounting-review'); Livewire::component('accounting-review',ReviewItems::class); } }
