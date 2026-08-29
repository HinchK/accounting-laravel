<?php

declare(strict_types=1);

namespace Liberu\Accounting\AccountsPayable\Actions;

use Illuminate\Support\Facades\DB;
use Liberu\Accounting\AccountsPayable\Enums\PayableStatus;
use Liberu\Accounting\AccountsPayable\Events\OpenItemCreated;
use Liberu\Accounting\AccountsPayable\Exceptions\InvalidPayable;
use Liberu\Accounting\AccountsPayable\Models\PayableOpenItem;
use Liberu\Accounting\FinancialMasterData\Enums\PartyType;
use Liberu\Accounting\FinancialMasterData\Models\Party;

final class CreateOpenItem
{
    public function handle(array $attributes): PayableOpenItem
    {
        return DB::transaction(function () use ($attributes) {
            $amount = (float) ($attributes['original_amount'] ?? 0);
            if (empty($attributes['party_id']) || blank($attributes['reference'] ?? null) || $amount <= 0 || blank($attributes['currency'] ?? null)) {
                throw new InvalidPayable('A payable requires a supplier, reference, positive amount, and currency.');
            }
            if (! Party::query()->whereKey($attributes['party_id'])->where('type', PartyType::Supplier)->exists()) {
                throw new InvalidPayable('Open items can only be created for an existing supplier.');
            }
            $item = PayableOpenItem::create(array_merge($attributes, ['paid_amount' => 0, 'status' => PayableStatus::Open]));
            app(EnsureAccount::class)->handle((int) $item->party_id);
            app(RecalculateAccountBalance::class)->handle((int) $item->party_id);

            DB::afterCommit(fn (): mixed => event(new OpenItemCreated(PayableOpenItem::query()->findOrFail($item->getKey()))));

            return $item->refresh();
        });
    }
}
