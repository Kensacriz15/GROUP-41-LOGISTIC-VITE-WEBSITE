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
        Schema::create('lms_g41_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('sku')->unique();
            $table->json('attributes')->nullable();
            $table->integer('current_stock')->default(0);
            $table->string('unit_of_measure');
            $table->integer('reorder_level')->unsigned();
            $table->integer('safety_stock')->unsigned()->nullable();
            $table->enum('type', ['raw_material', 'component', 'finished_good']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('lms_g41_products');
    }
};
