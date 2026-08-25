<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayable\Actions;

use Liberu\Accounting\AccountsPayable\Enums\PayableStatus;
use Liberu\Accounting\AccountsPayable\Exceptions\InvalidPayable;
use Liberu\Accounting\AccountsPayable\Models\PayablePayment;

final class RecordPayment
{
    public function handle(array $attributes): PayablePayment
    {
        if ((float) ($attributes['amount'] ?? 0) <= 0 || blank($attributes['currency'] ?? null)) {
            throw new InvalidPayable('A payment requires a positive amount and currency.');
        }

return PayablePayment::create(array_merge($attributes, ['applied_amount' => 0, 'status' => PayableStatus::Unapplied]));
    }
}
