<?php

namespace App\Http\Controllers;

use App\Helpers\FIMNotify;
use App\Models\InventorySpace;
use App\Models\InventorySpaceInvitation;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class InventorySpaceController extends Controller
{
    //region InventorySpace Functions
    public static function handleRegisterInventorySpace(array $data): InventorySpace|null
    {
        $tenant = InventorySpace::create($data);

        // attach user to the newly created tenant and set the current time in db
        $tenant->members()->attach(auth()->user(), [
            'created_at' => now()
        ]);

        return $tenant;
    }
    //endregion

    //region User Invitations
    public static function handleDeleteInvitation(Action $action): Action|null
    {
        return $action
            ->requiresConfirmation()
            ->modalHeading('Delete Invitation')
            ->modalDescription('Are you sure you want to delete this invitation?')
            ->modalSubmitActionLabel('Confirm')
            ->action(function (array $arguments, Repeater $component): void {
                $invitationId = explode('-', $arguments['item'])[1];
                $invitation = InventorySpaceInvitation::find($invitationId)->first();

                if(!$invitation) {
                    Notification::make()
                        ->title('Invitation not found')
                        ->body('Error while deleting the invitation. Please refresh the page and try again.')
                        ->icon(Heroicon::ExclamationTriangle)
                        ->color(Color::Red)
                        ->send();

                    return;
                }

                $invitation->delete();

                Notification::make()
                    ->title('Invitation deleted')
                    ->icon(Heroicon::Check)
                    ->color(Color::Green)
                    ->send();

                redirect()->route('filament.app.tenant.profile', [
                    'tenant' => Filament::getTenant()->slug
                ]);
            });
    }

    public static function handleCreateInvitation(): Action
    {
        return Action::make('inviteUserAction')
            ->modalIcon(Heroicon::Envelope)
            ->modalWidth(Width::Small)
            ->label('Invite User')
            ->color('primary')
            ->schema([
                TextInput::make('username')
                    ->label('Enter the username of the person you want to invite:')
                    ->prefixIcon(Heroicon::User)
                    ->required(),
                TextInput::make('expiration_time')
                    ->label('Expiration time (in days):')
                    ->numeric()
                    ->step(1)
                    ->minValue(1)
                    ->maxValue(31)
                    ->required()
                    ->default(7)
                    ->suffix('days')
                    ->prefixIcon(HeroIcon::Calendar)
            ])
            ->action(function (array $data, $livewire) {
                $user = User::where('username', $data['username'])->first();

                // check if given user exists
                if(!$user) {
                    FIMNotify::error(message: 'User not found');
                    return;
                }

                // check if invitation already exists
                $inv = InventorySpaceInvitation::where([
                    'user_id' => $user->id,
                    'inventory_space_id' => Filament::getTenant()->id
                ])->first();

                if($inv) {
                    FIMNotify::error(message: 'The user already has a pending invitation.');
                    return;
                }

                //TODO: Add button to block invitations from tenant (+ unblock interface)

                $isi = InventorySpaceInvitation::make([
                    'user_id' => $user->id,
                    'inventory_space_id' => Filament::getTenant()->id,
                    'inviter_id' => auth()->user()->id,
                    'expires_at' => Carbon::now()->addDays((int) $data['expiration_time'])
                ]);

                if($isi->saveOrFail())
                {
                    FIMNotify::user(
                        message: 'You have been invited to a new Inventory Space!',
                        title: 'Inventory Space Invitation',
                        icon: Heroicon::Envelope,
                        color: 'primary',
                        user: $user
                    );

                    FIMNotify::success(title: 'Invitation send!', icon: Heroicon::Envelope);
                } else {
                    FIMNotify::error(message: 'Error while creating invitation. Please try again later.');
                }
            });
    }
    //endregion
}
