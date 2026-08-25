<?php
declare(strict_types=1);namespace Liberu\Accounting\Mileage;use Illuminate\Support\ServiceProvider;final class MileageServiceProvider extends ServiceProvider {public function boot():void{$this->loadMigrationsFrom(__DIR__.'/../database/migrations');}public function register():void{$this->app->singleton(\Liberu\Accounting\Mileage\Queries\MileageQuery::class);}}
