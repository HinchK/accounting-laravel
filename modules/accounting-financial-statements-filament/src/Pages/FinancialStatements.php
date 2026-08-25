<?php
declare(strict_types=1);
namespace Liberu\Accounting\FinancialStatementsFilament\Pages;
use Filament\Pages\Page;
final class FinancialStatements extends Page { protected static ?string $navigationLabel='Financial statements'; protected static string $view='accounting-financial-statements-filament::financial-statements'; public int $bookId; public function mount(int $bookId):void{$this->bookId=$bookId;} }
