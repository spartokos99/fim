<?php

namespace App\Filament\Resources\InventorySpaces\Pages;

use App\Filament\Resources\InventorySpaces\InventorySpaceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInventorySpace extends EditRecord
{
    protected static string $resource = InventorySpaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
