<?php
declare(strict_types=1);
namespace Liberu\Accounting\FinancialStatementsFilament;
use Filament\Contracts\Plugin; use Filament\Panel;
final class FinancialStatementsFilamentPlugin implements Plugin { public function getId():string{return 'accounting-financial-statements';} public function register(Panel $panel):void{} public function boot(Panel $panel):void{} public static function make():static{return new static;} }
