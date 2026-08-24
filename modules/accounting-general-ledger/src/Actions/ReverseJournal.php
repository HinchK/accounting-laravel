<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Actions;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\GeneralLedger\Enums\{JournalStatus,JournalType};
use Liberu\Accounting\GeneralLedger\Exceptions\InvalidJournal;
use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
final class ReverseJournal {
    public function handle(JournalEntry $journal, array $attributes=[], ?string $actor=null): JournalEntry { return DB::transaction(function() use($journal,$attributes,$actor){$journal=JournalEntry::query()->with('lines')->lockForUpdate()->findOrFail($journal->getKey());if($journal->status!==JournalStatus::Posted) throw new InvalidJournal('Only posted journals may be reversed.');$lines=$journal->lines->map(fn($line)=>['account_id'=>$line->account_id,'debit'=>$line->credit,'credit'=>$line->debit,'description'=>$line->description,'dimensions'=>$line->dimensions])->all();$reversal=app(CreateJournal::class)->handle($attributes+['book_id'=>$journal->book_id,'entry_date'=>now()->toDateString(),'journal_type'=>JournalType::Reversal->value,'description'=>'Reversal of '.$journal->entry_number,'reversal_of_id'=>$journal->id],$lines);app(PostJournal::class)->handle($reversal,$actor);$journal->update(['status'=>JournalStatus::Reversed]);return $reversal;}); }
}
