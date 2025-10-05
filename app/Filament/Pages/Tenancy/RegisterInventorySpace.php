<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\InventorySpace;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class RegisterInventorySpace extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register InventorySpace';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->minLength(3)
                    ->maxLength(30)
                    ->trim()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required(),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                ColorPicker::make('color')
            ]);
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
