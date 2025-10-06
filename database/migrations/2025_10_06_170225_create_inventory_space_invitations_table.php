<?php

use App\Models\InventorySpace;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_space_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(InventorySpace::class);
            $table->foreignIdFor(User::class, 'inviter_id');
            $table->datetime('expires_at');
            $table->timestamps();

            $table->unique(['user_id', 'inventory_space_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_space_invitations');
    }
};
