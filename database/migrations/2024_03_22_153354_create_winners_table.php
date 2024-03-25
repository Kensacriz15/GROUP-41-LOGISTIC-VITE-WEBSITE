<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidding_product_id')->constrained('lms_g41_bidding_products');
            $table->foreignId('bid_id')->constrained('lms_g49_bids'); // Ensure this matches your bids table
            // Any other winner-specific details
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('winners');
    }
};
