<?php

namespace App\Filament\Resources\InventorySpaceLogs\Pages;

use App\Filament\Resources\InventorySpaceLogs\InventorySpaceLogResource;
use Filament\Resources\Pages\ListRecords;

class ListInventorySpaceLogs extends ListRecords
{
    protected static string $resource = InventorySpaceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
