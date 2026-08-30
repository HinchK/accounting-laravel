<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\SalesReceipts\Pages;

use App\Filament\App\Resources\SalesReceipts\SalesReceiptResource;
use App\Models\SalesReceipt;
use Filament\Resources\Pages\EditRecord;

/**
 * @property-read SalesReceipt $record
 */
class EditSalesReceipt extends EditRecord
{
    #[\Override]
    protected static string $resource = SalesReceiptResource::class;

    protected function afterSave(): void
    {
        $this->record->calculateTotals();
    }
}
