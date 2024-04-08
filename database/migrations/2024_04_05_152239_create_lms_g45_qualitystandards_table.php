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
        Schema::create('lms_g45_qualitystandards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('purpose_scope');
            $table->text('quality_policy');
            $table->text('quality_objectives');
            $table->text('documentation_procedures');
            $table->text('quality_control_measures');
            $table->text('training_competence');
            $table->text('monitoring_measurement');
            $table->text('non_conformance_management');
            $table->text('continuous_improvement');
            $table->text('compliance_regulations');
            $table->text('supplier_management');
            $table->text('customer_satisfaction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_g45_qualitystandards');
    }
};
