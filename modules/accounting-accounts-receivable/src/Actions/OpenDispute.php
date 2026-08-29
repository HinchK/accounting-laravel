<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsReceivable\Actions;

use Illuminate\Support\Facades\DB;
use Liberu\Accounting\AccountsReceivable\Enums\DisputeStatus;
use Liberu\Accounting\AccountsReceivable\Events\DisputeOpened;
use Liberu\Accounting\AccountsReceivable\Exceptions\InvalidReceivable;
use Liberu\Accounting\AccountsReceivable\Models\ReceivableDispute;
use Liberu\Accounting\AccountsReceivable\Models\ReceivableOpenItem;

final class OpenDispute
{
    public function handle(ReceivableOpenItem $item, string $reason, ?float $amount = null): ReceivableDispute
    {
        $amount ??= $item->outstanding();
        if (blank($reason) || $amount <= 0 || $amount > $item->outstanding() || $item->status->value === 'settled') {
            throw new InvalidReceivable('A dispute requires a valid reason and amount within the open balance.');
        }
        if ($item->disputes()->where('status', DisputeStatus::Open)->exists()) {
            throw new InvalidReceivable('An open dispute already exists for this item.');
        }
        $dispute = DB::transaction(function () use ($item, $amount, $reason): ReceivableDispute {
            $dispute = $item->disputes()->create(['amount' => $amount, 'reason' => $reason, 'status' => DisputeStatus::Open, 'opened_at' => now()]);
            $item->update(['status' => 'disputed']);
            DB::afterCommit(fn (): mixed => event(new DisputeOpened(ReceivableDispute::query()->findOrFail($dispute->getKey()))));

            return $dispute;
        });

        return $dispute;
    }
}
