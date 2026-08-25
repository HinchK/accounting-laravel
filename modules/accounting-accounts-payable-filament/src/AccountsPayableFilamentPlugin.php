<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayableFilament;

use Filament\Contracts\Plugin;
use Filament\Panel;

final class AccountsPayableFilamentPlugin implements Plugin
{
    public static function make(): static { return new self(); }
    public function getId(): string { return 'accounting-accounts-payable'; }
    public function register(Panel $panel): void {}
    public function boot(Panel $panel): void {}
}
