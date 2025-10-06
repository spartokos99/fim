<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventorySpace extends Model
{
    protected $table = 'inventory_spaces';

    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    //region Default Functions
    protected static function booted(): void
    {
        static::creating(function($model){
            $model->user_id = auth()->id();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    //endregion

    //region Relationships
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'inventory_space_user', 'inventory_space_id', 'user_id');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(InventorySpaceInvitation::class);
    }
    //endregion
}
