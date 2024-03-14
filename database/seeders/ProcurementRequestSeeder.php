<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Faker\Provider\LoremIpsum;


class ProcurementRequestSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $statuses = ['pending', 'approved', 'rejected', 'in_progress'];
        $origins = ['internal', 'external_eis'];
        $departmentNames = Department::whereNotIn('id', [1, 2, 3, 4, 5, 6, 7, 8])->pluck('name');

        $departments = Department::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            DB::table('lms_g41_procurement_requests')->insert([
                'user_id' => $faker->randomElement($users),
                'department_id' => $faker->randomElement($departments),
                'request_origin' => $faker->randomElement($origins),
                'status' => $faker->randomElement($statuses),
                'external_request_id' => $faker->ean8(), // Or other unique ID
                'request_data' => $this->generateRequestData($faker), // Call the function here
                'created_at' => now(), // Use current timestamp
                'updated_at' => now()
            ]);
        }
    }

    private function generateRequestData($faker)
    {
      $products = [
        'Forklifts' => ['Toyota Electric Forklift', 'Hyster Diesel Forklift', 'Crown Reach Truck'],
        'Pallet Jacks' => ['Crown Pallet Jack', 'Yale Electric Pallet Jack', 'Jungheinrich Walkie Pallet Truck'],
        'Shipping Containers' => ['20ft Shipping Container', '40ft Shipping Container', 'Refrigerated Shipping Container'],
        'Packaging Materials' => ['Cardboard Boxes', 'Bubble Wrap', 'Stretch Film', 'Packing Tape'],
        'Warehouse Racking' => ['Selective Pallet Racking', 'Drive-in Racking', 'Cantilever Racking'],
        'Office Supplies' => ['Stapler', 'Binder Clips', 'Pens (Pack of 10)', 'Notepads'],
    ];

        $quantities = [1, 2, 3, 5, 10, 20];

        $items = [];
        for ($i = 0; $i < rand(1, 3); $i++) {
            $category = $faker->randomElement(array_keys($products));
            $product = $faker->randomElement($products[$category]);

            $items[] = [
                'product_name' => $product,
                'description' => $faker->sentence(), // Placeholder description
                'quantity' => $faker->randomElement($quantities)
            ];
        }

        $justificationTemplates = [
          "This request is for essential %s to optimize our logistics operations.",
          "We need %s to meet the increasing demand for our Department.",
          "Upgrading our %s will enhance the efficiency of handling raw materials and optimize production processes.",
          "Investing in %s will enable us to expand our product range and cater to a wider customer base.",
          "Upgrading our %s will enhance our efficiency in handling logistics operations."
        ];
        $justification = sprintf(
            $faker->randomElement($justificationTemplates),
            $faker->randomElement(array_keys($products)), // Random category or product
            $faker->company() // Placeholder project name
        );

        return json_encode([
            'items' => $items,
            'requester_info' => [
                'name' => $faker->name,
                'contact' => $faker->email
            ],
            'justification' => $justification
        ]);
    }
}
