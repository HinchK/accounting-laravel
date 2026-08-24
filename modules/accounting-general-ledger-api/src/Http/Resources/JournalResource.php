<?php
declare(strict_types=1);
namespace Liberu\Accounting\GeneralLedgerApi\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class JournalResource extends JsonResource { public function toArray($request): array { return ['id'=>(string)$this->id,'type'=>'accounting-journal','attributes'=>['book_id'=>$this->book_id,'entry_number'=>$this->entry_number,'entry_date'=>$this->entry_date?->toDateString(),'journal_type'=>$this->journal_type->value,'status'=>$this->status->value,'description'=>$this->description,'lines'=>$this->lines->map(fn($line)=>['account_id'=>$line->account_id,'debit'=>(string)$line->debit,'credit'=>(string)$line->credit,'description'=>$line->description])->values()]]; } }
