<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Liberu\Accounting\Core\Models\LegalEntity;
use Liberu\Accounting\CoreApi\Http\Requests\StoreLegalEntityRequest;
use Liberu\Accounting\CoreApi\Http\Resources\LegalEntityResource;

it('keeps the legal entity resource explicit and stable', function (): void {
    $entity = new LegalEntity([
        'name' => 'Liberu Limited',
        'registration_number' => 'GB-123',
        'currency_code' => 'GBP',
        'accounting_basis' => 'accrual',
        'is_active' => true,
    ]);
    $entity->id = 7;

    $resolved = (new LegalEntityResource($entity))->resolve(Request::create('/'));

    expect($resolved)->toHaveKeys(['id', 'type', 'attributes'])
        ->and($resolved['id'])->toBe('7')
        ->and($resolved['type'])->toBe('accounting-legal-entity')
        ->and($resolved['attributes'])->toMatchArray([
            'name' => 'Liberu Limited',
            'currency_code' => 'GBP',
            'accounting_basis' => 'accrual',
            'is_active' => true,
        ]);
});

it('declares the supported legal entity input contract', function (): void {
    $rules = app(StoreLegalEntityRequest::class)->rules();

    expect($rules)->toMatchArray([
        'name' => ['required', 'string', 'max:255'],
        'registration_number' => ['nullable', 'string', 'max:255'],
        'currency_code' => ['required', 'string', 'size:3', 'regex:/^[A-Z]{3}$/'],
        'accounting_basis' => ['nullable', 'in:accrual,cash'],
    ]);
});
