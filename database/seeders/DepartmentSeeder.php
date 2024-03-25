<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
      DB::table('lms_g41_departments')->insert([
        ['name' => 'Hotel Department'],
        ['name' => 'Restaurant Department'],
        ['name' => 'HR Department'],
        ['name' => 'Marketing Department'],
        ['name' => 'Accounting and Finance Department'],
        ['name' => 'Sales and Marketing Department'],
        ['name' => 'Operations Department'],
        ['name' => 'E-Commerse Department'],
    ]);
    }
}
