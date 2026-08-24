<?php
namespace Liberu\Accounting\PoliciesFilament\Resources;
use Filament\Forms\Components\{DatePicker,KeyValue,Select,TextInput,Toggle};
use Filament\Resources\Resource;
use Filament\Resources\Pages\PageRegistration;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\{IconColumn,TextColumn};
use Filament\Tables\Table;
use Liberu\Accounting\Policies\Models\PolicyRule;
use Liberu\Accounting\PoliciesFilament\Resources\PolicyRuleResource\Pages\ListPolicyRules;
final class PolicyRuleResource extends Resource { protected static ?string $model=PolicyRule::class; protected static string|\BackedEnum|null $navigationIcon='heroicon-o-adjustments-horizontal'; protected static string|\UnitEnum|null $navigationGroup='Accounting'; public static function form(Schema $schema):Schema{return $schema->components([TextInput::make('book_id')->required()->numeric(),Select::make('category')->required()->options(array_combine(array_map(fn($c)=>$c->value,\Liberu\Accounting\Policies\Enums\PolicyCategory::cases()),array_map(fn($c)=>ucwords(str_replace('_',' ',$c->value)),\Liberu\Accounting\Policies\Enums\PolicyCategory::cases()))),TextInput::make('key')->required()->maxLength(100),KeyValue::make('value')->required(),DatePicker::make('effective_from')->required(),DatePicker::make('effective_until'),Toggle::make('is_active')->default(true)]);} public static function table(Table $table):Table{return $table->columns([TextColumn::make('book_id'),TextColumn::make('category')->badge(),TextColumn::make('key')->searchable(),TextColumn::make('effective_from')->date(),TextColumn::make('effective_until')->date(),IconColumn::make('is_active')->boolean()]);} /** @return array<string,PageRegistration> */ public static function getPages():array{return ['index'=>ListPolicyRules::route('/')];} }
