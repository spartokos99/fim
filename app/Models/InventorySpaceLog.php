<?php

namespace App\Models;

use App\Enums\LogLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventorySpaceLog extends Model
{
    protected $fillable = [
        'inventory_space_id',
        'level',
        'target',
        'action',
        'message',
        'trigger_date',
        'user_id'
    ];

    protected $casts = [
        'trigger_date' => 'datetime',
        'level' => LogLevel::class
    ];

    //region Relationships
    public function inventorySpace(): BelongsTo
    {
        return $this->belongsTo(InventorySpace::class);
    }

    public function triggerUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //endregion
}
