<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Database\Factories\SupplierFactory;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        Supplier::factory()->count(5)->create();
    }
}
