<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $car_listings = [
            [
                'car_model_id' => 1,
                'vendor_id' => 1,
                'vin' => '3HGCM82633A123456',
                'price' => 20000,
                'color' => 'Red',
                'mileage' => 15000,
                'condition' => 'Used',
                'year' => 2020,
                'currency' => 'USD',
                'location' => 'New York, NY',
                'status' => 'available',
                'added_by' => 1,
            ],
            [
                'car_model_id' => 2,
                'vendor_id' => 2,
                'vin' => '3HGCM82623A123456',
                'price' => 25000,
                'color' => 'Red',
                'mileage' => 15000,
                'condition' => 'Used',
                'year' => 2001,
                'currency' => 'USD',
                'location' => 'New York, NY',
                'status' => 'available',
                'added_by' => 1,
            ],
            [
                'car_model_id' => 3,
                'vendor_id' => 1,
                'vin' => '3HGCM82663A123456',
                'price' => 30000,
                'color' => 'Red',
                'mileage' => 15000,
                'condition' => 'Used',
                'year' => 2013,
                'currency' => 'USD',
                'location' => 'New York, NY',
                'status' => 'sold',
                'added_by' => 1,
            ],
        ];

        foreach ($car_listings as $listing) {
            \App\Models\CarListing::create($listing);
        }
    }
}
