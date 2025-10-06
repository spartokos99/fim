<?php

namespace App\Http\Controllers;

use App\Models\InventorySpaceInvitation;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Http\Request;

class InventorySpaceController extends Controller
{
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
                        ->color('danger')
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
}
