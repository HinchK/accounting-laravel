<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedgerLivewire\Livewire;
use Livewire\Component; use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
final class Journals extends Component { public int $bookId; public function mount(int $bookId):void{$this->bookId=$bookId;} public function render(){return view('accounting-general-ledger-livewire::journals',['journals'=>JournalEntry::with('lines')->where('book_id',$this->bookId)->latest()->paginate(25)]);} }
