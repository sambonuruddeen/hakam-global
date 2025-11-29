<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MakesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $car_makes = [
            ['name' => 'Hyundai', 'country' => 'South Korea', 'website' => 'https://www.hyundai.com'],
            ['name' => 'Kia', 'country' => 'South Korea', 'website' => 'https://www.kia.com'],
            ['name' => 'Toyota', 'country' => 'Japan', 'website' => 'https://www.toyota.com'],
            ['name' => 'Ford', 'country' => 'USA', 'website' => 'https://www.ford.com'],
            ['name' => 'BMW', 'country' => 'Germany', 'website' => 'https://www.bmw.com'],
            ['name' => 'Honda', 'country' => 'Japan', 'website' => 'https://www.honda.com'],
            ['name' => 'Chevrolet', 'country' => 'USA', 'website' => 'https://www.chevrolet.com'],
            ['name' => 'Mercedes-Benz', 'country' => 'Germany', 'website' => 'https://www.mercedes-benz.com'],
            ['name' => 'Nissan', 'country' => 'Japan', 'website' => 'https://www.nissan-global.com'],
            ['name' => 'Volkswagen', 'country' => 'Germany', 'website' => 'https://www.vw.com'],

        ];

        foreach ($car_makes as $make) {
            \App\Models\Make::create($make);
        }
    }
}
