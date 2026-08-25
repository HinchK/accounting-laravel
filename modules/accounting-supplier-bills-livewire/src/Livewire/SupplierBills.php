<?php

declare(strict_types=1);

namespace Liberu\Accounting\SupplierBillsLivewire\Livewire;

use Illuminate\Auth\Access\AuthorizationException;
use Liberu\Accounting\SupplierBills\Actions\CreateSupplierBill;
use Liberu\Accounting\SupplierBills\Models\SupplierBill;
use Livewire\Component;

final class SupplierBills extends Component
{
    public ?int $partyId = null;
    public string $search = '';
    public bool $showForm = false;

    public function mount(?int $partyId = null): void
    {
        abort_unless(auth()->check(), 403);
        $this->partyId = $partyId;
    }

    public function create(array $attributes, array $lines, CreateSupplierBill $action): void
    {
        if (! auth()->user()) {
            throw new AuthorizationException('Authentication is required to create supplier bills.');
        }
        $action->handle($attributes, $lines);
        $this->showForm = false;
        $this->dispatch('supplier-bill-created');
    }

    public function render(): mixed
    {
        $bills = SupplierBill::query()->with('party')->when($this->partyId, fn ($query) => $query->where('party_id', $this->partyId))->when($this->search !== '', fn ($query) => $query->where('bill_number', 'like', '%'.$this->search.'%'))->latest()->paginate(25);
        return view('accounting-supplier-bills::supplier-bills', ['bills'=>$bills]);
    }
}
