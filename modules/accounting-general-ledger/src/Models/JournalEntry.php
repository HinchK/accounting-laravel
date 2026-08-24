<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo,HasMany};
use Liberu\Accounting\Core\Models\Book;
use Liberu\Accounting\GeneralLedger\Enums\{JournalStatus,JournalType};
class JournalEntry extends Model {
    protected $table='accounting_journal_entries';
    protected $fillable=['book_id','entry_number','entry_date','journal_type','status','description','source_type','source_id','reversal_of_id','posted_by','posted_at','metadata'];
    protected $casts=['entry_date'=>'date','posted_at'=>'datetime','metadata'=>'array','status'=>JournalStatus::class,'journal_type'=>JournalType::class];
    public function book(): BelongsTo { return $this->belongsTo(Book::class); }
    public function lines(): HasMany { return $this->hasMany(JournalLine::class); }
    public function reversalOf(): BelongsTo { return $this->belongsTo(self::class,'reversal_of_id'); }
    public function isBalanced(): bool { $totals=$this->lines()->selectRaw('COALESCE(SUM(debit),0) debits, COALESCE(SUM(credit),0) credits')->first(); return bccomp((string)$totals->debits,(string)$totals->credits,2)===0 && $this->lines()->count() >= 2; }
    public function totalDebits(): string { return (string)$this->lines()->sum('debit'); }
    public function totalCredits(): string { return (string)$this->lines()->sum('credit'); }
}
