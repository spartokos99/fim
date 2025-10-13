<?php

namespace App\Filament\Resources\InventorySpaceLogs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InventorySpaceLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('inventorySpace.name')
                    ->label('Inventory space'),
                TextEntry::make('level')
                    ->badge(),
                TextEntry::make('target'),
                TextEntry::make('action'),
                TextEntry::make('message')
                    ->columnSpanFull(),
                TextEntry::make('trigger_date')
                    ->dateTime(),
                TextEntry::make('user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
