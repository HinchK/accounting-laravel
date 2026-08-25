<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayableApi\Policies;

use Liberu\Accounting\AccountsPayable\Models\PayableOpenItem;

final class AccountingAccountsPayablePolicy
{
    public function viewAny(?object $user = null): bool
    {
        return $user !== null;
    }

    public function view(?object $user, PayableOpenItem $item): bool
    {
        return $user !== null;
    }

    public function create(?object $user = null): bool
    {
        return $user !== null;
    }

    public function update(?object $user, PayableOpenItem $item): bool
    {
        return $user !== null;
    }

    public function delete(?object $user, PayableOpenItem $item): bool
    {
        return $user !== null;
    }
}
