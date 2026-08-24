<?php
declare(strict_types=1);
namespace Liberu\Accounting\FinancialStatementsLivewire\Livewire;
use Livewire\Component; use Liberu\Accounting\FinancialStatements\Queries\StatementQuery;
final class Statements extends Component { public int $bookId; public string $startDate; public string $endDate; public function mount(int $bookId,string $startDate, string $endDate):void{$this->bookId=$bookId;$this->startDate=$startDate;$this->endDate=$endDate;} public function render(){return view('accounting-financial-statements-livewire::statements',['statement'=>app(StatementQuery::class)->profitAndLoss($this->bookId,$this->startDate,$this->endDate)]);} }
