<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class InventorySpace extends Model
{
    protected $table = 'tenants';

    #region: Default Properties
    protected $fillable = [
        'name',
        'slug',
        'color',
    ];
    #endregion

    #region: Default Functions
    protected static function booted(): void
    {
        static::creating(function($model){
            $model->user_id = auth()->id();
        });
    }
    #endregion

    #region: Relationships
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_user', 'user_id', 'tenant_id');
    }
    #endregion
}
