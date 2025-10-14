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
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'username',
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


    //region Relationships
    public function inventorySpaces(): BelongsToMany
    {
        return $this->belongsToMany(InventorySpace::class, 'inventory_space_user', 'user_id', 'inventory_space_id');
    }
    //endregion

    //region Tenancy Functions
    public function getTenants(Panel $panel): Collection
    {
        return $this->inventorySpaces;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->inventorySpaces()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    //endregion
}
