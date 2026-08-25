<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsReceivable\Actions;

use Liberu\Accounting\AccountsReceivable\Exceptions\InvalidReceivable;
use Liberu\Accounting\AccountsReceivable\Models\ReceivableDispute;
use Liberu\Accounting\AccountsReceivable\Models\ReceivableOpenItem;

final class OpenDispute
{
    public function handle(ReceivableOpenItem $item, string $reason, ?float $amount = null): ReceivableDispute
    {
        $amount ??= $item->outstanding();
        if (blank($reason) || $amount <= 0 || $amount > $item->outstanding()) {
            throw new InvalidReceivable('A dispute requires a valid reason and amount within the open balance.');
        }$dispute = $item->disputes()->create(['amount' => $amount, 'reason' => $reason, 'status' => 'open', 'opened_at' => now()]);
        $item->update(['status' => 'disputed']);

        return $dispute;
    }
}
