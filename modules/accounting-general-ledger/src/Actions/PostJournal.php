<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Actions;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\GeneralLedger\Enums\JournalStatus;
use Liberu\Accounting\GeneralLedger\Exceptions\InvalidJournal;
use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
use Liberu\Accounting\GeneralLedger\Events\JournalPosted;
final class PostJournal {
    public function handle(JournalEntry $journal, ?string $actor=null): JournalEntry { return DB::transaction(function() use($journal,$actor){$journal=JournalEntry::query()->with('lines.account')->lockForUpdate()->findOrFail($journal->getKey());if($journal->status!==JournalStatus::Draft) throw new InvalidJournal('Only draft journals may be posted.');if(!$journal->isBalanced()) throw new InvalidJournal('Journal must be balanced before posting.');foreach($journal->lines as $line){$account=$line->account()->lockForUpdate()->firstOrFail();if(!$account->is_active||!$account->allow_manual_entry)throw new InvalidJournal('Every journal account must be active and permit manual entries.');}$journal->update(['status'=>JournalStatus::Posted,'posted_by'=>$actor,'posted_at'=>now()]);DB::afterCommit(fn()=>event(new JournalPosted($journal->fresh('lines'),$actor)));return $journal->refresh()->load('lines');}); }
}
