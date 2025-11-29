<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $car_models = [
            ['make_id' => 1, 'name' => 'Elantra', 'year' => 2020, 'engine_type' => '4 Cylinder', 'fuel_type' => 'Petrol', 'transmission' => 'Automatic', 'body_style' => 'Truck',  'drive_train' => 'FWD'],
            ['make_id' => 2, 'name' => 'Sorento', 'year' => 2021, 'engine_type' => 'V8', 'fuel_type' => 'Petrol', 'transmission' => 'Automatic', 'body_style' => 'Sedan',  'drive_train' => 'FWD'],
            ['make_id' => 3, 'name' => 'Camry', 'year' => 2019, 'engine_type' => '4 Cylinder', 'fuel_type' => 'Petrol', 'transmission' => 'Automatic', 'body_style' => 'Sedan',  'drive_train' => 'AWD'],
            ['make_id' => 4, 'name' => 'Mustang', 'year' => 2018, 'engine_type' => '4 Cylinder', 'fuel_type' => 'Petrol', 'transmission' => 'Automatic', 'body_style' => 'SUV',  'drive_train' => 'FWD'],
            ['make_id' => 5, 'name' => 'X5', 'year' => 2022, 'engine_type' => 'Hybrid', 'fuel_type' => 'Petrol', 'transmission' => 'Automatic', 'body_style' => 'Sedan',  'drive_train' => 'FWD'],
            ['make_id' => 6, 'name' => 'Civic', 'year' => 2020, 'engine_type' => '4 Cylinder', 'fuel_type' => 'Petrol', 'transmission' => 'Automatic', 'body_style' => 'Sedan',  'drive_train' => 'RWD'],
            ['make_id' => 7, 'name' => 'Malibu', 'year' => 2019, 'engine_type' => '4 Cylinder', 'fuel_type' => 'Petrol', 'transmission' => 'Automatic', 'body_style' => 'Sedan',  'drive_train' => 'FWD'],
            ['make_id' => 8, 'name' => 'C-Class', 'year' => 2021, 'engine_type' =>'v6', 'fuel_type' => 'Petrol', 'transmission' => 'Manual', 'body_style' => 'Sedan',  'drive_train' => 'FWD'],
            ['make_id' => 9, 'name' => 'Altima', 'year' => 2018, 'engine_type' => '4 Cylinder', 'fuel_type' => 'Petrol', 'transmission' => 'Automatic', 'body_style' => 'Hatchback',  'drive_train' => 'FWD'],
            ['make_id' => 10, 'name' => 'Golf', 'year' => 2022, 'engine_type' => '4 Cylinder', 'fuel_type' => 'Petrol', 'transmission' => 'Automatic', 'body_style' => 'Sedan',  'drive_train' => 'RWD'],
        ];

        foreach($car_models as $car_model){
            \App\Models\CarModel::create($car_model);
        }
    }
}
