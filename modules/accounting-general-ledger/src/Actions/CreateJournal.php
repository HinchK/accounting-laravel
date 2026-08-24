<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Actions;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\GeneralLedger\Enums\JournalStatus;
use Liberu\Accounting\GeneralLedger\Exceptions\InvalidJournal;
use Liberu\Accounting\GeneralLedger\Models\JournalEntry;
use Liberu\Accounting\GeneralLedger\Events\JournalCreated;
final class CreateJournal {
    public function handle(array $attributes, array $lines): JournalEntry { return DB::transaction(function() use($attributes,$lines) {
        if (count($lines)<2) throw new InvalidJournal('A journal requires at least two lines.');
        $debits=0.0; $credits=0.0; foreach($lines as $line){$debit=(float)($line['debit']??0);$credit=(float)($line['credit']??0);if($debit<0||$credit<0||($debit>0&&$credit>0)||($debit==0&&$credit==0)) throw new InvalidJournal('Each line must contain either a positive debit or credit.');$debits+=$debit;$credits+=$credit;}
        if(abs($debits-$credits)>0.005) throw new InvalidJournal('Journal debits and credits must balance.');
        $entry=JournalEntry::create($attributes+['status'=>JournalStatus::Draft->value]); $entry->lines()->createMany($lines); DB::afterCommit(fn()=>event(new JournalCreated($entry->fresh('lines')))); return $entry->load('lines');
    }); }
}
