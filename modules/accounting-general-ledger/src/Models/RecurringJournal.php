<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedger\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo; use Liberu\Accounting\Core\Models\Book;
class RecurringJournal extends Model { protected $table='accounting_recurring_journals'; protected $fillable=['book_id','name','frequency','next_run_on','end_on','is_active','description','lines','metadata']; protected $casts=['next_run_on'=>'date','end_on'=>'date','is_active'=>'bool','lines'=>'array','metadata'=>'array']; public function book():BelongsTo{return $this->belongsTo(Book::class);} }
