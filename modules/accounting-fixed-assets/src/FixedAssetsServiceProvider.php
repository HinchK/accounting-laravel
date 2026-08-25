<?php
declare(strict_types=1);namespace Liberu\Accounting\FixedAssets;use Illuminate\Support\ServiceProvider;use Liberu\Accounting\FixedAssets\Queries\AssetQuery;final class FixedAssetsServiceProvider extends ServiceProvider {public function register():void{$this->app->singleton(AssetQuery::class);}public function boot():void{$this->loadMigrationsFrom(__DIR__.'/../database/migrations');}}
