<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('requires authentication for accounting core legal entities', function (): void {
    $this->getJson('/api/v1/accounting/accounting-core/legal-entities')
        ->assertUnauthorized();
});

it('requires the accounting core read ability', function (): void {
    Sanctum::actingAs(User::factory()->create(), ['invoices:read']);

    $this->getJson('/api/v1/accounting/accounting-core/legal-entities')
        ->assertForbidden();
});

it('creates and lists legal entities through the scoped contract', function (): void {
    $user = User::factory()->create();

    Sanctum::actingAs($user, ['accounting.core.write']);

    $this->postJson('/api/v1/accounting/accounting-core/legal-entities', [
        'name' => 'Liberu Limited',
        'registration_number' => 'GB-123',
        'currency_code' => 'GBP',
        'accounting_basis' => 'accrual',
    ])->assertCreated()
        ->assertJsonPath('data.type', 'accounting-legal-entity')
        ->assertJsonPath('data.attributes.currency_code', 'GBP');

    Sanctum::actingAs($user, ['accounting.core.read']);

    $this->getJson('/api/v1/accounting/accounting-core/legal-entities')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.attributes.name', 'Liberu Limited');
});

it('rejects invalid currency input at the API boundary', function (): void {
    Sanctum::actingAs(User::factory()->create(), ['accounting.core.write']);

    $this->postJson('/api/v1/accounting/accounting-core/legal-entities', [
        'name' => 'Invalid Limited',
        'currency_code' => 'gbp',
    ])->assertUnprocessable()
        ->assertJsonValidationErrors(['currency_code']);
});
