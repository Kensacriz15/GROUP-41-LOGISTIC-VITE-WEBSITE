<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB facade

class QualityStandardsSeeder extends Seeder
{
    public function run()
    {
        DB::table('lms_g45_qualitystandards')->insert([
            [
                'name' => 'ISO 9001:2015',
                'purpose_scope' => 'Quality management system standard that helps organizations meet customer and regulatory requirements.',
                'quality_policy' => 'The organization is committed to providing products and services that meet customer requirements and comply with applicable regulations.',
                'quality_objectives' => '1. Enhance customer satisfaction\n2. Improve product quality\n3. Increase operational efficiency',
                'documentation_procedures' => 'Document control, record keeping, and change management procedures are implemented to maintain and update quality documentation.',
                'quality_control_measures' => 'Quality inspections, testing, and process controls are implemented to ensure product conformity.',
                'training_competence' => 'Employees receive training to develop the necessary skills and knowledge to perform their assigned tasks effectively.',
                'monitoring_measurement' => 'Performance indicators and metrics are used to monitor and measure the effectiveness of the quality management system.',
                'non_conformance_management' => 'Processes are in place to identify, document, and address non-conformities and implement corrective actions.',
                'continuous_improvement' => 'The organization is committed to continuously improving its processes and systems to enhance quality and customer satisfaction.',
                'compliance_regulations' => 'The organization complies with relevant legal and regulatory requirements related to its products and services.',
                'supplier_management' => 'Suppliers are selected, evaluated, and managed to ensure they meet quality requirements and contribute to customer satisfaction.',
                'customer_satisfaction' => 'Customer feedback and satisfaction surveys are used to measure and improve customer satisfaction.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'AS9100D',
                'purpose_scope' => 'Quality management system standard for the aerospace industry.',
                'quality_policy' => 'The organization is committed to delivering safe and reliable aerospace products and services that meet customer and regulatory requirements.',
                'quality_objectives' => '1. Enhance product safety\n2. Improve on-time delivery performance\n3. Reduce non-conformities',
                'documentation_procedures' => 'Document control, configuration management, and records management procedures are implemented to ensure compliance and traceability.',
                'quality_control_measures' => 'Inspection, testing, and verification processes are implemented to ensure product conformity and reliability.',
                'training_competence' => 'Employees receive training to develop the necessary skills and knowledge to perform their aerospace-related tasks effectively.',
                'monitoring_measurement' => 'Performance metrics and audits are used to monitor and measure the effectiveness of the quality management system.',
                'non_conformance_management' => 'Non-conformances and non-compliances are identified, documented, and addressed through corrective and preventive actions.',
                'continuous_improvement' => 'The organization is committed to continuously improving its processes, products, and services to enhance customer satisfaction and operational efficiency.',
                'compliance_regulations' => 'The organization complies with applicable aerospace regulations, standards, and customer requirements.',
                'supplier_management' => 'Suppliers are selected, evaluated, and managed to ensure they meet aerospace quality requirements and contribute to product safety and reliability.',
                'customer_satisfaction' => 'Customer feedback and performance metrics are used to measure and improve customer satisfaction.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more quality standards data here (repeat the array)
        ]);
    }
}
