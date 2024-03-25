<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition()
    {
        $cities = ['Manila', 'Quezon City', 'Makati', 'Pasig', 'Mandaluyong', /* Add more */];
        $subdivisions = ['Palm Village', 'Rosewood Subdivision', 'Pinecrest Subdivision', /* Add more */];
        $firstNames = ['Juan', 'Maria', 'Jose', 'Ana', 'Pedro', /* Add more */];
        $lastNames = ['Dela Cruz', 'Santos', 'Reyes', 'Garcia', 'Lopez', /* Add more */];
        $companySuffixes = ['Corporation', 'Inc.', 'Co.', 'Trading', 'Enterprises'];

        return [
            'supplier_name' => $this->faker->firstName() . ' ' . $this->faker->companySuffix() . ' ' . $this->faker->randomElement($companySuffixes),
            'address' => $this->faker->numberBetween(1, 100) . ' ' . $this->faker->streetName() . ', ' . $this->faker->randomElement($subdivisions),
            'city' => $this->faker->randomElement($cities),
            'zip_code' => $this->faker->randomNumber(4),
            'contact_name' => $this->faker->firstName($firstNames) . ' ' . $this->faker->lastName($lastNames),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => '+63 9' . $this->faker->randomNumber(9),
            'status' => $this->faker->randomElement(['active', 'inactive'])
        ];
    }
}
