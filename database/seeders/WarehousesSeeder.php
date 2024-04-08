<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class WarehousesSeeder extends Seeder
{
    public function run()
    {
        DB::table('lms_g42_warehouses')->insert([
            'name' => 'Main Warehouse',
            'location' => 'City Center',
            'capacity' => 10000
        ]);

        // Add more warehouses using insert()
    }
}
