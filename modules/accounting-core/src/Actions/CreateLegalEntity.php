<?php

declare(strict_types=1);

namespace Liberu\Accounting\Core\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Liberu\Accounting\Core\Events\LegalEntityCreated;
use Liberu\Accounting\Core\Models\LegalEntity;

final class CreateLegalEntity
{
    public function __construct(private readonly Dispatcher $events) {}

    /**
     * @param  array{name: string, registration_number?: string|null, currency_code: string, accounting_basis?: string}  $attributes
     */
    public function handle(array $attributes): LegalEntity
    {
        return DB::transaction(function () use ($attributes): LegalEntity {
            $entity = LegalEntity::query()->create($attributes + ['is_active' => true]);

            $this->events->dispatch(new LegalEntityCreated($entity));

            return $entity;
        });
    }
}
