<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityStandard extends Model
{
    use HasFactory;

    protected $table = 'lms_g45_qualitystandards';

    protected $fillable = [
        'name',
        'purpose_scope',
        'quality_policy',
        'quality_objectives',
        'documentation_procedures',
        'quality_control_measures',
        'training_competence',
        'monitoring_measurement',
        'non_conformance_management',
        'continuous_improvement',
        'compliance_regulations',
        'supplier_management',
        'customer_satisfaction',
    ];
}
