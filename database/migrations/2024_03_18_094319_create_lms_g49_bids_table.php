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
        Schema::create('lms_g49_bids', function (Blueprint $table) {
          $table->id();
          $table->foreignId('bidding_product_id')->constrained('lms_g41_bidding_products');
          $table->unsignedBigInteger('supplier_id')->nullable();
          $table->unsignedBigInteger('vendor_id')->nullable();

          $table->foreign('supplier_id')->references('id')->on('lms_g49_suppliers');
          $table->foreign('vendor_id')->references('id')->on('lms_g49_vendors');

          $table->unique(['bidding_product_id', 'supplier_id']);
          $table->unique(['bidding_product_id', 'vendor_id']);
          $table->decimal('amount', 10, 2);  // Example for price
          $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_g49_bids');
        $table->dropForeign(['bidding_product_id']);
        $table->dropForeign(['vendor_id']);
        $table->dropForeign(['supplier_id']);
    }
};
