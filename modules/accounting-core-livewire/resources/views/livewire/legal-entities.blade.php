<div>
    <form wire:submit="save" aria-label="Create legal entity">
        <label for="accounting-core-name">Name</label>
        <input id="accounting-core-name" type="text" wire:model="name">
        @error('name') <span role="alert">{{ $message }}</span> @enderror

        <label for="accounting-core-currency">Currency</label>
        <input id="accounting-core-currency" type="text" wire:model="currencyCode" maxlength="3">
        @error('currencyCode') <span role="alert">{{ $message }}</span> @enderror

        <label for="accounting-core-basis">Accounting basis</label>
        <select id="accounting-core-basis" wire:model="accountingBasis">
            <option value="accrual">Accrual</option>
            <option value="cash">Cash</option>
        </select>

        <button type="submit" wire:loading.attr="disabled">Create legal entity</button>
    </form>

    <ul aria-label="Legal entities">
        @forelse ($legalEntities as $legalEntity)
            <li wire:key="legal-entity-{{ $legalEntity->id }}">{{ $legalEntity->name }} ({{ $legalEntity->currency_code }})</li>
        @empty
            <li>No legal entities yet.</li>
        @endforelse
    </ul>

    {{ $legalEntities->links() }}
</div>
