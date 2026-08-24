<?php
namespace Liberu\Accounting\CoreFilament\Resources\BookResource\Pages;
use Filament\Resources\Pages\ListRecords;
use Liberu\Accounting\CoreFilament\Resources\BookResource;
final class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;
    protected function getHeaderActions(): array { return [\Filament\Actions\CreateAction::make()]; }
}
