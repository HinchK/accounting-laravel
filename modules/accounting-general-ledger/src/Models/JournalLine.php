<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Liberu\Accounting\ChartOfAccounts\Models\Account;
class JournalLine extends Model {
    protected $table='accounting_journal_lines'; protected $fillable=['journal_entry_id','account_id','debit','credit','description','dimensions'];
    protected $casts=['debit'=>'decimal:2','credit'=>'decimal:2','dimensions'=>'array'];
    public function journalEntry(): BelongsTo { return $this->belongsTo(JournalEntry::class); }
    public function account(): BelongsTo { return $this->belongsTo(Account::class); }
}
