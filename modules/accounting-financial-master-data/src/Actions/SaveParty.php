<?php

declare(strict_types=1);

namespace Liberu\Accounting\FinancialMasterData\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\FinancialMasterData\Events\MasterRecordCreated;
use Liberu\Accounting\FinancialMasterData\Exceptions\DuplicateMasterRecord;
use Liberu\Accounting\FinancialMasterData\Models\Party;

final class SaveParty
{
    public function __construct(private readonly Dispatcher $events) {}

    /** @param array<string, mixed> $attributes */
    public function handle(array $attributes, ?Party $party = null): Party
    {
        return DB::transaction(function () use ($attributes, $party): Party {
            $query = Party::query()->where('legal_entity_id', $attributes['legal_entity_id'] ?? $party?->legal_entity_id)
                ->where('type', $attributes['type'] ?? $party?->type?->value);
            if (! empty($attributes['email'])) {
                $query->whereRaw('lower(email) = ?', [mb_strtolower((string) $attributes['email'])]);
            } elseif (! empty($attributes['name'])) {
                $query->whereRaw('lower(name) = ?', [mb_strtolower(trim((string) $attributes['name']))]);
            }
            if ($party?->exists) {
                $query->where($party->getKeyName(), '!=', $party->getKey());
            }
            if ($query->exists()) {
                throw new DuplicateMasterRecord('A matching customer or supplier already exists for this legal entity.');
            }

            $party ??= new Party();
            $created = ! $party->exists;
            $party->fill($attributes);
            $party->save();
            if ($created) {
                $this->events->dispatch(new MasterRecordCreated($party));
            }

            return $party->refresh();
        });
    }
}
