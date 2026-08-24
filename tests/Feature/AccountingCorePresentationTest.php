<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Liberu\Accounting\CoreFilament\AccountingCoreFilamentPlugin;
use Liberu\Accounting\CoreFilament\Resources\LegalEntityResource;
use Liberu\Accounting\CoreLivewire\AccountingCoreLivewireServiceProvider;
use Liberu\Accounting\CoreLivewire\Livewire\LegalEntities;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->app->register(AccountingCoreLivewireServiceProvider::class, force: true);
});

it('registers the accounting core presentation boundaries', function (): void {
    expect(AccountingCoreFilamentPlugin::make()->getId())->toBe('liberu-accounting-core')
        ->and(LegalEntityResource::getModel())->toBe('Liberu\\Accounting\\Core\\Models\\LegalEntity');
});

it('creates legal entities through the livewire boundary', function (): void {
    Livewire::test(LegalEntities::class)
        ->set('name', 'Presentation Entity')
        ->set('currencyCode', 'USD')
        ->set('accountingBasis', 'accrual')
        ->call('save')
        ->assertDispatched('legal-entity-created');

    $this->assertDatabaseHas('accounting_legal_entities', [
        'name' => 'Presentation Entity',
        'currency_code' => 'USD',
    ]);
});

it('rejects invalid livewire currency input', function (): void {
    Livewire::test(LegalEntities::class)
        ->set('name', 'Invalid Entity')
        ->set('currencyCode', 'usd')
        ->call('save')
        ->assertHasErrors(['currencyCode']);
});
