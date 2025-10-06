<?php

use App\Models\InventorySpace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_spaces', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('slug')->unique();
            $table->string('color', 7)->nullable();
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });

        Schema::create('inventory_space_user', function(Blueprint $table){
            $table->id();
            $table->foreignIdFor(InventorySpace::class, 'inventory_space_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignIdFor(User::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->datetime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_spaces');
        Schema::dropIfExists('inventory_space_user');
    }
};
