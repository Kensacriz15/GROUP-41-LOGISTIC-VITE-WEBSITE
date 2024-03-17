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
        Schema::table('lms_g41_biddings', function (Blueprint $table) {
            $table->unsignedBigInteger('bidder_id')->nullable(); // Or the exact data type you need
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lms_g41_biddings', function (Blueprint $table) {
            //
        });
    }
};
