<?php

namespace App\Filament\Pages\Tenancy;

use App\Filament\Pages\Tenancy\TenantForm;
use App\Http\Controllers\InventorySpaceController;
use App\Models\InventorySpace;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;

class RegisterInventorySpace extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Inventory Space';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components(TenantForm::getFields(false));
    }

    protected function handleRegistration(array $data): InventorySpace
    {
        return InventorySpaceController::handleRegisterInventorySpace($data);
    }
}
