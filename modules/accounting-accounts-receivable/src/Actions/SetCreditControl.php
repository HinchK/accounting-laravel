<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsReceivable\Actions;

use Liberu\Accounting\AccountsReceivable\Models\ReceivableAccount;

final class SetCreditControl
{
    public function handle(int $partyId, ?float $creditLimit = null, ?bool $hold = null, ?string $reason = null): ReceivableAccount
    {
        $account = app(EnsureAccount::class)->handle($partyId);
        $account->update(array_filter(['credit_limit' => $creditLimit, 'credit_hold' => $hold, 'hold_reason' => $reason], static fn ($v) => $v !== null));

        return $account->refresh();
    }
}
