<?php

namespace App\Filament\Pages\Tenancy;

use App\Filament\Pages\Tenancy\TenantForm;
use App\Http\Controllers\InventorySpaceController;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

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
                Tabs::make('Tabs')
                    ->tabs([
                        //region Tab : Members
                        Tab::make('Members')
                            ->badge(Filament::getTenant()->members()->count())
                            ->badgeColor('primary')
                            ->schema([
                                Repeater::make('Members')
                                    ->label('Manager members')
                                    ->relationship('members')
                                    ->disableItemCreation()
                                    ->table([
                                        TableColumn::make('User Name'),
                                        TableColumn::make('Role'),
                                        TableColumn::make('Member since'),
                                    ])
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->disabled(),
                                        TextInput::make('role')
                                            ->required()
                                            ->disabled(),
                                        DateTimePicker::make('created_at')
                                            ->required()
                                            ->disabled()
                                    ])
                            ]),
                        //endregion

                        //region Tab : Invitations
                        Tab::make('Invitations')
                            ->badge(Filament::getTenant()->invitations()->count())
                            ->badgeColor('secondary')
                            ->schema([
                                Repeater::make('Invitations')
                                    ->label('Manage user invitations')
                                    ->relationship('invitations')
                                    ->table([
                                        TableColumn::make('User Name'),
                                        TableColumn::make('Inviter'),
                                        TableColumn::make('Status'),
                                        TableColumn::make('Expires At')
                                    ])
                                    ->schema([
                                        TextInput::make('user_name')
                                            ->required()
                                            ->disabled()
                                            ->formatStateUsing(fn ($state, $record) => $record?->user?->name),
                                        TextInput::make('inviter_name')
                                            ->required()
                                            ->disabled()
                                            ->formatStateUsing(fn ($state, $record) => $record?->inviter?->name),
                                        TextInput::make('status')
                                            ->required()
                                            ->disabled(),
                                        DateTimePicker::make('expires_at')
                                            ->required()
                                            ->disabled()
                                    ])
                                ->disableItemCreation()
                                ->deleteAction(fn (Action $action) => InventorySpaceController::handleDeleteInvitation($action))
                            ])
                        //endregion
                    ])
        ]));
    }

    //TODO: Refresh page after saving settings
}
