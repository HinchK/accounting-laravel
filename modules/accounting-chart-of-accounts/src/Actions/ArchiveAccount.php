<?php

declare(strict_types=1);

namespace Liberu\Accounting\ChartOfAccounts\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\ChartOfAccounts\Events\AccountArchived;
use Liberu\Accounting\ChartOfAccounts\Exceptions\InvalidAccountHierarchy;
use Liberu\Accounting\ChartOfAccounts\Models\Account;

final class ArchiveAccount
{
    public function __construct(private readonly Dispatcher $events) {}

    public function handle(Account $account): Account
    {
        return DB::transaction(function () use ($account): Account {
            if ($account->children()->where('is_active', true)->exists()) {
                throw new InvalidAccountHierarchy('An account with active child accounts cannot be archived.');
            }

            $account->update(['is_active' => false]);
            $account = $account->refresh();
            $this->events->dispatch(new AccountArchived($account));

            return $account;
        });
    }
}
