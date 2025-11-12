<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $users = [1, 2, 3];

        for ($i = 0; $i < 30; $i++) {
            Customer::create([
                'name' => $faker->name,
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'account_number' => 'ACC' . $faker->unique()->numberBetween(1000, 9999),
                'meter_number' => 'MTR' . $faker->unique()->numberBetween(1000, 9999),
                'transformer' => 'TRF-' . strtoupper($faker->randomLetter()) . $faker->numberBetween(1, 9),
                'created_by' => $faker->randomElement($users),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
