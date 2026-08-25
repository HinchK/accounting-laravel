<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayable\Actions;

use Liberu\Accounting\AccountsPayable\Enums\DisputeStatus;
use Liberu\Accounting\AccountsPayable\Models\PayableDispute;

final class ResolveDispute
{
    public function handle(PayableDispute $dispute, string $resolution, bool $accepted = false): PayableDispute
    {
        $dispute->update([
            'status' => $accepted ? DisputeStatus::Resolved : DisputeStatus::Rejected,
            'resolution' => $resolution,
            'resolved_at' => now(),
        ]);

        return $dispute->refresh()->load('openItem');
    }
}
