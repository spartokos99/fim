<?php

namespace App\Filament\Pages\Tenancy;

use App\Filament\Resources\InventorySpaces\RelationManagers\InvitationsRelationManager;
use App\Filament\Resources\InventorySpaces\RelationManagers\MembersRelationManager;
use App\Filament\Resources\InventorySpaces\RelationManagers\RolesRelationManager;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EditInventorySpace extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Settings';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components(array_merge(TenantForm::getFields(true),
                [
                    //TODO: refresh badges after actions
                    Tabs::make('Tabs')
                        ->contained(false)
                        ->tabs([
                            //region Tab : Members
                            Tab::make('Members')
                                ->icon(Heroicon::Users)
                                ->badge(Filament::getTenant()->members()->count())
                                ->badgeColor('primary')
                                ->live()
                                ->schema([
                                    Livewire::make(
                                        MembersRelationManager::class,
                                        fn(Page $livewire, $record) => [
                                            'ownerRecord' => $record,
                                            'pageClass' => $livewire::class
                                        ]
                                    )
                                ]),
                            //endregion

                            //region Tab : Invitations
                            Tab::make('Invitations')
                                ->icon(Heroicon::Envelope)
                                ->badge(Filament::getTenant()->invitations()->count())
                                ->badgeColor('secondary')
                                ->live()
                                ->schema([
                                    Livewire::make(
                                        InvitationsRelationManager::class,
                                        fn(Page $livewire, $record) => [
                                            'ownerRecord' => $record,
                                            'pageClass' => $livewire::class
                                        ]
                                    )
                                ]),
                            //endregion

                            //region Tab : Roles
                            Tab::make('Roles')
                                ->icon(Heroicon::UserGroup)
                                ->badge(Filament::getTenant()->roles()->count())
                                ->badgeColor('secondary')
                                ->live()
                                ->schema([
                                    Livewire::make(
                                        RolesRelationManager::class,
                                        fn(Page $livewire, $record) => [
                                            'ownerRecord' => $record,
                                            'pageClass' => $livewire::class
                                        ]
                                    )
                                ])
                            //endregion
                        ])
                ]
            ));
    }

    //TODO: Refresh page after saving settings
}
