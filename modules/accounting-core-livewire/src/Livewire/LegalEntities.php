<?php

namespace Liberu\Accounting\CoreLivewire\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Liberu\Accounting\Core\Actions\CreateLegalEntity;
use Liberu\Accounting\Core\Models\LegalEntity;
use Livewire\Component;

final class LegalEntities extends Component
{
    public string $name = '';

    public string $currencyCode = '';

    public string $accountingBasis = 'accrual';

    public function save(CreateLegalEntity $createLegalEntity): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'currencyCode' => ['required', 'string', 'size:3', 'regex:/^[A-Z]{3}$/'],
            'accountingBasis' => ['required', 'in:accrual,cash'],
        ]);

        $createLegalEntity->handle([
            'name' => $validated['name'],
            'currency_code' => $validated['currencyCode'],
            'accounting_basis' => $validated['accountingBasis'],
        ]);

        $this->reset('name', 'currencyCode');
        $this->dispatch('legal-entity-created');
    }

    public function render(): View
    {
        return ViewFacade::make('accounting-core-livewire::livewire.legal-entities', [
            'legalEntities' => LegalEntity::query()->latest()->paginate(15),
        ]);
    }
}
