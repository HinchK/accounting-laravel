<?php
declare(strict_types=1);namespace Liberu\Accounting\Leases;use Illuminate\Support\ServiceProvider;final class LeasesServiceProvider extends ServiceProvider {public function boot():void{$this->loadMigrationsFrom(__DIR__.'/../database/migrations');}public function register():void{$this->app->singleton(\Liberu\Accounting\Leases\Queries\LeaseQuery::class);}}
