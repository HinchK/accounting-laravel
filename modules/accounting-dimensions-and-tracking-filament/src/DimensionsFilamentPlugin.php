<?php
declare(strict_types=1);
namespace Liberu\Accounting\DimensionsFilament;
use Filament\Contracts\Plugin; use Filament\Panel;
final class DimensionsFilamentPlugin implements Plugin { public function getId():string{return 'accounting-dimensions-and-tracking';} public function register(Panel $panel):void{} public function boot(Panel $panel):void{} public static function make():static{return new static;} }
