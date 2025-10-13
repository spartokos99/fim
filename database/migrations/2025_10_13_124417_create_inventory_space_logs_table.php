<?php

use App\Enums\LogLevel;
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
        Schema::create('inventory_space_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InventorySpace::class);
            $table->enum('level', LogLevel::cases());
            $table->string('target', 30);
            $table->string('action', 15);
            $table->text('message');
            $table->datetime('trigger_date');
            $table->foreignIdFor(User::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_space_logs');
    }
};
