<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use Notifiable;

    #region: Default Variables
    protected $fillable = [
        'name',
        'email',
        'password',
        'anon_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'anon_token'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    #endregion

    #region: Tenancy Functions
    public function inventorySpaces(): BelongsToMany
    {
        return $this->belongsToMany(InventorySpace::class, 'tenant_user', 'tenant_id', 'user_id');
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->inventorySpaces;
    }

    public function canAccessTenant(Model $iventorySpace): bool
    {
        return $this->inventorySpaces()->whereKey($iventorySpace)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    #endregion
}
