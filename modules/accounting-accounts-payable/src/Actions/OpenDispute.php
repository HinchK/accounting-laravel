<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayable\Actions;

use Liberu\Accounting\AccountsPayable\Enums\PayableStatus;
use Liberu\Accounting\AccountsPayable\Enums\DisputeStatus;
use Liberu\Accounting\AccountsPayable\Exceptions\InvalidPayable;
use Liberu\Accounting\AccountsPayable\Models\PayableDispute;
use Liberu\Accounting\AccountsPayable\Models\PayableOpenItem;

final class OpenDispute
{
    public function handle(PayableOpenItem $item, string $reason, ?float $amount = null): PayableDispute
    {
        $amount ??= $item->outstanding();
        if (blank($reason) || $amount <= 0 || $amount > $item->outstanding()) {
            throw new InvalidPayable('A dispute requires a valid reason and amount within the open balance.');
        }

        $dispute = $item->disputes()->create([
            'amount' => $amount,
            'reason' => $reason,
            'status' => DisputeStatus::Open,
            'opened_at' => now(),
        ]);
        $item->update(['status' => PayableStatus::Open]);

        return $dispute;
    }
}
