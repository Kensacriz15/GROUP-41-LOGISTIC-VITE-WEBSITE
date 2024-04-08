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
        Schema::create('lms_g41_skus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('lms_g41_products'); // Keep this
            $table->string('sku')->unique();
            $table->json('attributes')->nullable(); // For size, color, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_g41_skus');
    }
};
