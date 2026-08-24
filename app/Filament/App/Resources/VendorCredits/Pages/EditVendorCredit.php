<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\VendorCredits\Pages;

use App\Filament\App\Resources\VendorCredits\VendorCreditResource;
use App\Models\VendorCredit;
use Filament\Resources\Pages\EditRecord;

/**
 * @property-read VendorCredit $record
 */
class EditVendorCredit extends EditRecord
{
    #[\Override]
    protected static string $resource = VendorCreditResource::class;

    protected function afterSave(): void
    {
        $this->record->calculateTotals();
    }
}
