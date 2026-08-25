<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsReceivable\Actions;

use Illuminate\Support\Facades\DB;
use Liberu\Accounting\AccountsReceivable\Exceptions\InvalidReceivable;
use Liberu\Accounting\AccountsReceivable\Models\ReceivableReceipt;

final class RecordReceipt
{
    public function handle(array $attributes): ReceivableReceipt
    {
        return DB::transaction(function () use ($attributes) {
            $amount = (float) ($attributes['amount'] ?? 0);
            if ($amount <= 0 || blank($attributes['currency'] ?? null)) {
                throw new InvalidReceivable('A receipt requires a positive amount and currency.');
            }$receipt = ReceivableReceipt::create(array_merge($attributes, ['applied_amount' => 0, 'status' => 'unapplied', 'received_on' => $attributes['received_on'] ?? now()->toDateString()]));
            if (! empty($receipt->party_id)) {
                app(EnsureAccount::class)->handle((int) $receipt->party_id);
            }

            return $receipt;
        });
    }
}
