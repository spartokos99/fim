<?php

namespace App\Helpers;

use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class FIMNotify {

    public static function error(string $message, string $title = 'Error!'): void {
        Notification::make()
            ->title($title)
            ->body($message)
            ->icon(Heroicon::ExclamationTriangle)
            ->color(Color::Red)
            ->send();
    }

    public static function success(string $message = '', string $title = 'Success!', Heroicon $icon = Heroicon::Check): void {
        Notification::make()
            ->title($title)
            ->body($message)
            ->icon($icon)
            ->color(Color::Green)
            ->send();
    }

    public static function user(string $message, string $title, Heroicon $icon, User $user, $color = 'primary'): void {
        Notification::make()
            ->title($title)
            ->body($message)
            ->icon($icon)
            ->color($color)
            ->sendToDatabase($user);
    }

}
