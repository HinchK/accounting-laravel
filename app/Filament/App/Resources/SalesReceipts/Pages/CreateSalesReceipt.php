<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\SalesReceipts\Pages;

use App\Filament\App\Resources\SalesReceipts\SalesReceiptResource;
use App\Models\SalesReceipt;
use Filament\Resources\Pages\CreateRecord;

/**
 * @property-read SalesReceipt $record
 */
class CreateSalesReceipt extends CreateRecord
{
    #[\Override]
    protected static string $resource = SalesReceiptResource::class;

    protected function afterCreate(): void
    {
        $this->record->calculateTotals();
    }
}
