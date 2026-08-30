<?php

declare(strict_types=1);

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Liberu\Accounting\Core\Actions\CreateLegalEntity;
use Liberu\Accounting\Core\Enums\AccountingBasis;
use Liberu\Accounting\Core\Events\LegalEntityCreated;
use Liberu\Accounting\Core\Models\LegalEntity;

uses(RefreshDatabase::class);

it('exposes the supported accounting bases', function (): void {
    expect(AccountingBasis::cases())->toHaveCount(2)
        ->and(AccountingBasis::Accrual->value)->toBe('accrual');
});

it('creates a legal entity and dispatches its domain event', function (): void {
    $dispatcher = new Dispatcher(app());
    $dispatchedEvent = null;
    $dispatcher->listen(LegalEntityCreated::class, function (LegalEntityCreated $event) use (&$dispatchedEvent): void {
        $dispatchedEvent = $event;
    });

    $entity = (new CreateLegalEntity($dispatcher))->handle([
        'name' => 'Liberu Limited',
        'currency_code' => 'GBP',
    ]);

    expect($entity)->toBeInstanceOf(LegalEntity::class)
        ->and($entity->is_active)->toBeTrue()
        ->and($dispatchedEvent)->toBeInstanceOf(LegalEntityCreated::class)
        ->and($dispatchedEvent->legalEntity->is($entity))->toBeTrue();
});
