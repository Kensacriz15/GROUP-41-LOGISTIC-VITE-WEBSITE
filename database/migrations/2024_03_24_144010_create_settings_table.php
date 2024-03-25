<?php

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
      Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); // Ensure 'current_budget' is unique
        $table->string('value')->nullable(); // Or appropriate data type for your budget
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
