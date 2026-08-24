<?php

namespace Liberu\Accounting\CoreFilament\Resources\LegalEntityResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Liberu\Accounting\CoreFilament\Resources\LegalEntityResource;

final class ListLegalEntities extends ListRecords
{
    protected static string $resource = LegalEntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
