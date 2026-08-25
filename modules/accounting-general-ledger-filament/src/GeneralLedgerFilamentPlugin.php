<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedgerFilament;
use Filament\Contracts\Plugin; use Filament\Panel;
final class GeneralLedgerFilamentPlugin implements Plugin { public function getId(): string{return 'accounting-general-ledger';} public function register(Panel $panel): void{} public function boot(Panel $panel): void{} public static function make(): static{return new static;} }
