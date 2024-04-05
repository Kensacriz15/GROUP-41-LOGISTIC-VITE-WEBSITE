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
      Schema::create('lms_g41_payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('invoice_id')->constrained('lms_g41_invoices');
        $table->decimal('amount', 8, 2);
        $table->string('payment_method')->nullable(); // Optional
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_g41_payments');
    }
};
