<?php

namespace App\Filament\Resources\InventorySpaceLogs\Pages;

use App\Filament\Resources\InventorySpaceLogs\InventorySpaceLogResource;
use Filament\Resources\Pages\ViewRecord;

class ViewInventorySpaceLog extends ViewRecord
{
    protected static string $resource = InventorySpaceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
