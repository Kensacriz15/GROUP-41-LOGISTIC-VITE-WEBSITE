<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lms_g41_biddings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('procurement_request_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->enum('bid_type', ['vendor', 'supplier'])->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->text('delivery_terms')->nullable();
            $table->text('other_notes')->nullable();
            $table->string('status', 255)->nullable();
            $table->unsignedBigInteger('bidder_id')->nullable();
            $table->timestamps();

            $table->foreign('procurement_request_id')
                  ->references('id')
                  ->on('lms_g41_procurement_requests');

            $table->foreign('supplier_id')
                  ->references('id')
                  ->on('lms_g49_suppliers');

            $table->foreign('vendor_id')
                  ->references('id')
                  ->on('lms_g49_vendors');

            // Unique Constraint
            $table->unique(['procurement_request_id', 'bid_type', 'supplier_id', 'vendor_id'], 'short_bid_unique');
        });
    }

    // ... your down() method ...
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lms_g41_biddings');
    }
  };
