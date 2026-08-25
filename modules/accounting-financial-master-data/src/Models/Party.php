<?php

declare(strict_types=1);

namespace Liberu\Accounting\FinancialMasterData\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Liberu\Accounting\FinancialMasterData\Enums\PartyType;
use Liberu\Accounting\FinancialMasterData\Enums\RecordStatus;

class Party extends Model
{
    protected $table = 'accounting_master_parties';
    protected $fillable = ['legal_entity_id', 'type', 'reference', 'name', 'email', 'phone', 'tax_identifier', 'payment_term_id', 'credit_limit', 'status', 'metadata'];
    protected $attributes = ['status' => 'active', 'credit_limit' => 0];
    protected $casts = ['type' => PartyType::class, 'status' => RecordStatus::class, 'credit_limit' => 'decimal:2', 'metadata' => 'array'];

    public function addresses(): HasMany { return $this->hasMany(Address::class); }
    public function bankDetails(): HasMany { return $this->hasMany(BankDetailReference::class); }
    public function scopeActive(Builder $query): Builder { return $query->where('status', RecordStatus::Active->value); }
}
