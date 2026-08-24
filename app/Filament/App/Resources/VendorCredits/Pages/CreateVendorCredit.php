<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\VendorCredits\Pages;

use App\Filament\App\Resources\VendorCredits\VendorCreditResource;
use App\Models\VendorCredit;
use Filament\Resources\Pages\CreateRecord;

/**
 * @property-read VendorCredit $record
 */
class CreateVendorCredit extends CreateRecord
{
    #[\Override]
    protected static string $resource = VendorCreditResource::class;

    protected function afterCreate(): void
    {
        $this->record->calculateTotals();
    }
}
