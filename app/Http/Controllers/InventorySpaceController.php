<?php

namespace App\Http\Controllers;

use App\Models\InventorySpace;
use App\Models\InventorySpaceInvitation;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
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
    //endregion
}
