<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProcurementRequestSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $statuses = ['pending', 'approved', 'rejected', 'in_progress'];
        $origins = ['internal', 'external_eis'];

        $departments = Department::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            DB::table('lms_g41_procurement_requests')->insert([
                'user_id' => $faker->randomElement($users),
                'department_id' => $faker->randomElement($departments),
                'request_origin' => $faker->randomElement($origins),
                'status' => $faker->randomElement($statuses),
                'external_request_id' => $faker->randomNumber(8),
                'request_data' => $this->generateRequestData($faker),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    private function generateRequestData($faker)
    {
        $products = [
            'Office Supplies' => ['Ballpoint Pens', 'A4 Bond Paper', 'Staplers', 'Manila Folders'],
            'Electronics' => ['Laptops', 'Printers', 'Smartphones', 'Tablets'],
            'Furniture' => ['Office Chairs', 'Desks', 'File Cabinets', 'Bookshelves'],
            'Appliances' => ['Refrigerators', 'Air Conditioners', 'Washing Machines', 'Microwaves'],
            'Food and Beverages' => ['Coffee', 'Snacks', 'Bottled Water', 'Soft Drinks'],
            'Cleaning Supplies' => ['Cleaning Solution', 'Brooms', 'Mops', 'Trash Bags'],
            'Safety Equipment' => ['First Aid Kits', 'Safety Helmets', 'Safety Shoes', 'Safety Gloves'],
        ];

        $quantities = [1, 2, 3, 5, 10, 20];
        $items = [];

        for ($i = 0; $i < rand(1, 3); $i++) {
            $category = $faker->randomElement(array_keys($products));
            $product = $faker->randomElement($products[$category]);

            $items[] = [
                'product_name' => $product,
                'description' => $faker->sentence(),
                'quantity' => $faker->randomElement($quantities)
            ];
        }

        // Filipino Data Generation
        $firstNames = ['Juan', 'Maria', 'Jose', 'Ana', 'Pedro'];
        $lastNames = ['Dela Cruz', 'Santos', 'Reyes'];
        $cities = ['Manila', 'Quezon City', 'Caloocan'];
        $streets = ['Roxas Boulevard', 'EDSA', 'España Boulevard'];

        $requesterInfo = [
            'name' => $faker->randomElement($firstNames) . ' ' . $faker->randomElement($lastNames),
            'contact' => [
                'address' => $faker->numberBetween(100, 999) . ' ' . $faker->randomElement($streets) . ', ' . $faker->randomElement($cities),
                'phone' => '+63 9' . $faker->randomNumber(9)
            ]
        ];

        $justificationTemplates = [
            "This request is for essential %s to optimize our logistics operations.",
            "We need %s to meet the increasing demand for our Department.",
            "Upgrading our %s will enhance the efficiency of handling raw materials and optimize production processes.",
            "Investing in %s will enable us to expand our product range and cater to a wider customer base.",
            "Upgrading our %s will enhance our efficiency in handling logistics operations."
        ];

        $justification = sprintf(
            $faker->randomElement($justificationTemplates),
            $faker->randomElement(array_keys($products))
        );

        return json_encode([
            'items' => $items,
            'requester_info' => $requesterInfo,
            'justification' => $justification
        ]);
    }
  }
