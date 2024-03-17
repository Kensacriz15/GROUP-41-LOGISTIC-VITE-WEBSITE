<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
      Schema::create('lms_g41_bidding_products', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->text('description')->nullable();
          $table->decimal('starting_price', 10, 2)->nullable();
          $table->string('image')->nullable();
          $table->boolean('open_for_bids')->default(false);
          $table->string('request_origin')->nullable(); // Consider an Enum later
          $table->timestamp('start_date')->nullable();
          $table->timestamp('end_date')->nullable();
          $table->timestamps();
      });
  }

    public function down(): void
    {
        Schema::dropIfExists('lms_g41_bidding_products');
    }
};
