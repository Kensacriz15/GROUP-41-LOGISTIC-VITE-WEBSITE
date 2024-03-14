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
      Schema::create('lms_g41_procurement_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('lms_g41_users');
        $table->foreignId('department_id')->constrained('lms_g41_departments');
        $table->string('request_origin');
        $table->string('status');
        $table->string('external_request_id')->nullable();
        $table->json('request_data')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_g41_procurement_requests');
    }
};
