<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\VendorSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call([
        PermissionSeeder::class,
        RoleSeeder::class,
        SuperAdminSeeder::class,
    ]);
    $this->call(DepartmentSeeder::class);
    $this->call(ProcurementRequestSeeder::class);
    $this->call(SupplierSeeder::class );
    $this->call(VendorSeeder::class );
    }
}
