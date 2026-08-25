<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayable\Actions;

use Liberu\Accounting\AccountsPayable\Models\PayableAccount;

final class SetPaymentControl
{
    public function handle(int $partyId, ?bool $paymentHold = null, ?string $holdReason = null): PayableAccount
    {
        $account = app(EnsureAccount::class)->handle($partyId);
        $account->update(array_filter(['payment_hold' => $paymentHold, 'hold_reason' => $holdReason], static fn ($value): bool => $value !== null));

        return $account->refresh();
    }
}
