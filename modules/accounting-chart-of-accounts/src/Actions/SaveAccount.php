<?php

declare(strict_types=1);

namespace Liberu\Accounting\ChartOfAccounts\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\ChartOfAccounts\Enums\AccountType;
use Liberu\Accounting\ChartOfAccounts\Exceptions\InvalidAccountHierarchy;
use Liberu\Accounting\ChartOfAccounts\Events\AccountCreated;
use Liberu\Accounting\ChartOfAccounts\Models\Account;

final class SaveAccount
{
    public function __construct(private readonly Dispatcher $events) {}

    /** @param array<string, mixed> $attributes */
    public function handle(array $attributes, ?Account $account = null): Account
    {
        return DB::transaction(function () use ($attributes, $account): Account {
            $account ??= new Account();
            $type = $attributes['type'] ?? $account->type?->value;
            if ($type !== null && empty($attributes['normal_balance'])) {
                $attributes['normal_balance'] = AccountType::from($type)->defaultNormalBalance()->value;
            }
            $this->guardHierarchy($account, $attributes['parent_id'] ?? null, $attributes['legal_entity_id']);
            $wasRecentlyCreated = ! $account->exists;
            $account->fill($attributes);
            $account->save();

            if ($wasRecentlyCreated) {
                $this->events->dispatch(new AccountCreated($account));
            }

            return $account->refresh();
        });
    }

    private function guardHierarchy(Account $account, mixed $parentId, mixed $legalEntityId): void
    {
        if ($parentId === null) {
            return;
        }

        if ($account->exists && (int) $parentId === (int) $account->getKey()) {
            throw new InvalidAccountHierarchy('An account cannot be its own parent.');
        }

        $parent = Account::query()->find($parentId);
        if ($parent === null || (int) $parent->legal_entity_id !== (int) $legalEntityId) {
            throw new InvalidAccountHierarchy('The parent account must belong to the same legal entity.');
        }

        while ($parent !== null) {
            if ($account->exists && (int) $parent->getKey() === (int) $account->getKey()) {
                throw new InvalidAccountHierarchy('An account cannot be moved beneath one of its descendants.');
            }
            $parent = $parent->parent;
        }
    }
}
