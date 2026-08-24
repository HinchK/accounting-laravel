<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Actions;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\GeneralLedger\Enums\JournalStatus;
use Liberu\Accounting\GeneralLedger\Exceptions\InvalidJournal;
use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
final class PostJournal {
    public function handle(JournalEntry $journal, ?string $actor=null): JournalEntry { return DB::transaction(function() use($journal,$actor){$journal=JournalEntry::query()->with('lines.account')->lockForUpdate()->findOrFail($journal->getKey());if($journal->status!==JournalStatus::Draft) throw new InvalidJournal('Only draft journals may be posted.');if(!$journal->isBalanced()) throw new InvalidJournal('Journal must be balanced before posting.');foreach($journal->lines as $line){$account=$line->account()->lockForUpdate()->firstOrFail();$delta=$account->normal_balance->value==='debit'?(float)$line->debit-(float)$line->credit:(float)$line->credit-(float)$line->debit;$account->metadata=array_merge($account->metadata??[],['ledger_balance'=>(float)($account->metadata['ledger_balance']??0)+$delta]);$account->save();}$journal->update(['status'=>JournalStatus::Posted,'posted_by'=>$actor,'posted_at'=>now()]);return $journal->refresh()->load('lines');}); }
}
