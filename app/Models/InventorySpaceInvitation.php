<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventorySpaceInvitation extends Model
{
    protected $fillable = [
        'user_id',
        'inventory_space_id',
        'inviter_id',
        'status',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    //region Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id', 'id');
    }

    public function inventory_space(): BelongsTo
    {
        return $this->belongsTo(InventorySpace::class);
    }
    //endregion
}
