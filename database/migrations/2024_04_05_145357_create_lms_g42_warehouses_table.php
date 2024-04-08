<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

      public function up()
      {
          Schema::create('lms_g42_warehouses', function (Blueprint $table) {
              $table->id();
              $table->string('name');
              $table->text('location')->nullable(); // Made 'location' nullable
              $table->integer('capacity')->nullable(); // Made 'capacity' nullable
              $table->timestamps();
          });
      }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_g42_warehouses');
    }
};
