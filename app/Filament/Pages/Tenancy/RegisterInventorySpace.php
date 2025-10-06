<?php

namespace App\Filament\Pages\Tenancy;

use App\Filament\Resources\Users\Schemas\TenantForm;
use App\Models\InventorySpace;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;

class RegisterInventorySpace extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register InventorySpace';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components(TenantForm::getFields(false));
    }

    protected function handleRegistration(array $data): InventorySpace
    {
        $tenant = InventorySpace::create($data);

        // attach user to the newly created tenant and set the current time in db
        $tenant->members()->attach(auth()->user(), [
            'created_at' => now()
        ]);

        return $tenant;
    }
}
