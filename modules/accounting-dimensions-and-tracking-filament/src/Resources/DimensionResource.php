<?php

declare(strict_types=1);

namespace Liberu\Accounting\DimensionsFilament\Resources;

use Filament\Forms\Components\{Select, TextInput, Toggle};
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Table;
use Liberu\Accounting\Dimensions\Models\Dimension;
use Liberu\Accounting\DimensionsFilament\Resources\DimensionResource\Pages\{CreateDimension, EditDimension, ListDimensions};

final class DimensionResource extends Resource
{
    protected static ?string $model = Dimension::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([TextInput::make('code')->required(), TextInput::make('name')->required(), Select::make('kind')->options(['class' => 'Class/category', 'location' => 'Location', 'department' => 'Department', 'cost_center' => 'Cost center', 'profit_center' => 'Profit center', 'project' => 'Project', 'tag' => 'Tag'])->required(), Toggle::make('is_required'), Toggle::make('is_active')->default(true)]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('code'), TextColumn::make('name'), TextColumn::make('kind')->badge(), IconColumn::make('is_active')->boolean()]);
    }

    public static function getPages(): array
    {
        return ['index' => ListDimensions::route('/'), 'create' => CreateDimension::route('/create'), 'edit' => EditDimension::route('/{record}/edit')];
    }
}
