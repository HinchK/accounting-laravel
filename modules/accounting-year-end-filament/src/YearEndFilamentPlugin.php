<?php

declare(strict_types=1);

namespace Liberu\Accounting\YearEndFilament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Liberu\Accounting\YearEndFilament\Resources\YearEndCloseResource;

final class YearEndFilamentPlugin implements Plugin
{
    public static function make(): static
    {
        return new self();
    }

    public function getId(): string
    {
        return 'module-accounting-year-end-filament';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([YearEndCloseResource::class]);
    }

    public function boot(Panel $panel): void {}
}
