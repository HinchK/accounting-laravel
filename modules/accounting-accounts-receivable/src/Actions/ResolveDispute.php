<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsReceivable\Actions;

use Liberu\Accounting\AccountsReceivable\Enums\DisputeStatus;
use Liberu\Accounting\AccountsReceivable\Models\ReceivableDispute;

final class ResolveDispute
{
    public function handle(ReceivableDispute $dispute, string $resolution, bool $accepted = false): ReceivableDispute
    {
        $dispute->update(['status' => $accepted ? DisputeStatus::Resolved : DisputeStatus::Rejected, 'resolution' => $resolution, 'resolved_at' => now()]);
        $dispute->load('openItem');
        if ($dispute->openItem->status->value === 'disputed') {
            $dispute->openItem->update(['status' => $dispute->openItem->outstanding() <= 0 ? 'settled' : 'open']);
        }

        return $dispute->refresh();
    }
}
