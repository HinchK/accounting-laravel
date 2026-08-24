<?php

declare(strict_types=1);

namespace Liberu\Accounting\ChartOfAccounts\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Liberu\Accounting\ChartOfAccounts\Models\Account;

final readonly class AccountArchived
{
    use Dispatchable;

    public function __construct(public Account $account) {}
}
