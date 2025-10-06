<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class InventorySpace extends Model
{
    protected $table = 'tenants';

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
        return $this->belongsToMany(User::class, 'tenant_user', 'user_id', 'tenant_id');
    }
    //endregion
}
