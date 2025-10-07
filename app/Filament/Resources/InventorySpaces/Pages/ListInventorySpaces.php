<?php

namespace App\Filament\Resources\InventorySpaces\Pages;

use App\Filament\Resources\InventorySpaces\InventorySpaceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventorySpaces extends ListRecords
{
    protected static string $resource = InventorySpaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
