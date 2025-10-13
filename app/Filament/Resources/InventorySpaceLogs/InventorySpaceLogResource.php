<?php

namespace App\Filament\Resources\InventorySpaceLogs;

use App\Filament\Resources\InventorySpaceLogs\Pages\ListInventorySpaceLogs;
use App\Filament\Resources\InventorySpaceLogs\Pages\ViewInventorySpaceLog;
use App\Filament\Resources\InventorySpaceLogs\Schemas\InventorySpaceLogForm;
use App\Filament\Resources\InventorySpaceLogs\Schemas\InventorySpaceLogInfolist;
use App\Filament\Resources\InventorySpaceLogs\Tables\InventorySpaceLogsTable;
use App\Models\InventorySpaceLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InventorySpaceLogResource extends Resource
{
    protected static ?string $model = InventorySpaceLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::NumberedList;

    protected static ?string $navigationLabel = 'Logs';

    protected static ?string $recordTitleAttribute = 'id';

    public static function infolist(Schema $schema): Schema
    {
        return InventorySpaceLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventorySpaceLogsTable::configure($table);
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
            'index' => ListInventorySpaceLogs::route('/'),
            'view' => ViewInventorySpaceLog::route('/{record}')
        ];
    }
}
