<?php

namespace App\Filament\Pages\Tenancy;

use App\Filament\Resources\Users\Schemas\TenantForm;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Schema;

class EditInventorySpace extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'InventorySpace Settings';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components(TenantForm::getFields(true) + [
                
        ]);
    }
}