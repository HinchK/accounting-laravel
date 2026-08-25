<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayable\Actions;

use Illuminate\Support\Facades\DB;
use Liberu\Accounting\AccountsPayable\Enums\PayableStatus;
use Liberu\Accounting\AccountsPayable\Exceptions\InvalidPayable;
use Liberu\Accounting\AccountsPayable\Models\PayableOpenItem;

final class CreateOpenItem
{
    public function handle(array $attributes): PayableOpenItem
    {
        return DB::transaction(function () use ($attributes) {
            $amount = (float) ($attributes['original_amount'] ?? 0);
            if (empty($attributes['party_id']) || blank($attributes['reference'] ?? null) || $amount <= 0 || blank($attributes['currency'] ?? null)) {
                throw new InvalidPayable('A payable requires a supplier, reference, positive amount, and currency.');
            } $item = PayableOpenItem::create(array_merge($attributes, ['paid_amount' => 0, 'status' => PayableStatus::Open]));
            app(EnsureAccount::class)->handle((int) $item->party_id);
            app(RecalculateAccountBalance::class)->handle((int) $item->party_id);

            return $item->refresh();
        });
    }
}
