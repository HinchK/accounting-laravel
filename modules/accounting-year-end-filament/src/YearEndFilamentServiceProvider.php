<?php

declare(strict_types=1);

namespace Liberu\Accounting\YearEndFilament;

use Illuminate\Support\ServiceProvider;

final class YearEndFilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(YearEndFilamentPlugin::class, fn (): YearEndFilamentPlugin => YearEndFilamentPlugin::make());
    }
}
