<?php

declare(strict_types=1);

namespace Liberu\Accounting\ThreeWayMatchingFilament;

use Filament\Contracts\Plugin;
use Filament\Panel;

final class ThreeWayMatchingFilamentPlugin implements Plugin
{
    public static function make(): static
    {
        return new self();
    }

    public function getId(): string
    {
        return 'accounting-three-way-matching';
    }

    public function register(Panel $panel): void {}

    public function boot(Panel $panel): void {}
}
