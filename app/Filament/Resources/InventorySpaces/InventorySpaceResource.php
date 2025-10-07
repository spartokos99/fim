<?php

namespace App\Filament\Resources\InventorySpaces;

use App\Filament\Resources\InventorySpaces\Pages\CreateInventorySpace;
use App\Filament\Resources\InventorySpaces\Pages\EditInventorySpace;
use App\Filament\Resources\InventorySpaces\Pages\ListInventorySpaces;
use App\Filament\Resources\InventorySpaces\Schemas\InventorySpaceForm;
use App\Filament\Resources\InventorySpaces\Tables\InventorySpacesTable;
use App\Models\InventorySpace;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InventorySpaceResource extends Resource
{
    protected static ?string $model = InventorySpace::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static bool $isScopedToTenant = false;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $recordTitleAttribute = 'slug';

    public static function form(Schema $schema): Schema
    {
        return InventorySpaceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventorySpacesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventorySpaces::route('/'),
            'create' => CreateInventorySpace::route('/create'),
            'edit' => EditInventorySpace::route('/{record}/edit'),
        ];
    }
}
