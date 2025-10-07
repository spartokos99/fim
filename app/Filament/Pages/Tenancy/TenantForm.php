<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class TenantForm
{
    public static function getFields($edit): array
    {
        return [
            TextInput::make('name')
                ->minLength(3)
                ->maxLength(30)
                ->trim()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                ->required()
                ->disabled($edit),
            TextInput::make('slug')
                ->disabled()
                ->dehydrated()
                ->required(),
            ColorPicker::make('color')
        ];
    }
}
