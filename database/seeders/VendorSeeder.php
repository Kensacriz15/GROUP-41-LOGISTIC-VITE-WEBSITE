<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\VendorFactory;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    public function run()
    {
        Vendor::factory()->count(5)->create();
    }
}
