<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    protected static function booted(): void
    {
        static::creating(function($model){
            $model->user_id = auth()->id();
        });
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_user');
    }
}
