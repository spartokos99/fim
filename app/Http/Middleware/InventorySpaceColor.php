<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InventorySpaceColor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if user is authenticated
        if (! auth()->check()) {
            return $next($request);
        }

        // inject tenants primary color
        FilamentColor::register([
            'primary' => Filament::getTenant()->color ?? Color::Violet
        ]);

        return $next($request);
    }
}
