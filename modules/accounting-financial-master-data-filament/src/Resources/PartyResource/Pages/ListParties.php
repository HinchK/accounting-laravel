<?php
declare(strict_types=1);
namespace Liberu\Accounting\FinancialMasterDataFilament\Resources\PartyResource\Pages;
use Filament\Resources\Pages\ListRecords;
use Liberu\Accounting\FinancialMasterDataFilament\Resources\PartyResource;
final class ListParties extends ListRecords { protected static string $resource = PartyResource::class; protected function getHeaderActions(): array { return [\Filament\Actions\CreateAction::make()]; } }
