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
        Schema::create('lms_g41_inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('lms_g41_products');
            $table->foreignId('warehouse_id')->constrained('lms_g42_warehouses'); // Adjust `lms_g42_warehouses` if your table name is different
            $table->enum('transaction_type', ['IN', 'OUT']);
            $table->integer('quantity')->unsigned();
            $table->dateTime('date');
            $table->integer('damaged_quantity')->nullable();//->after('quantity');
            $table->string('reference')->nullable(); // For linking to orders etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('lms_g41_inventory_transactions', function (Blueprint $table) {

    });
    }
};
