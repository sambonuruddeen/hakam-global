<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cars = [
            ['make' => 'Toyota', 'model' => 'Camry', 'year' => 2020, 'vin' => '1HG-CM82633A004352', 'value' => 240070, 'currency' => 'NGN', 'color' => 'Blue', 'mileage' => 150000, 'engine_type' => 'V6', 'fuel_type' => 'Gasoline', 'transmission' => 'Automatic', 'body_style' => 'Sedan', 'drive_train' => 'AWD', 'condition' => 'Used', 'location' => 'Incheon', 'options' => json_encode(['Sunroof', 'Leather Seats']), 'status' => 'Available', 'additional_notes' => 'Well maintained, single owner.', 'added_by' => 1],
            ['make' => 'Honda', 'model' => 'Civic', 'year' => 2019, 'vin' => '1HG-CM82633A004552', 'value' => 27000, 'currency' => 'USD', 'color' => 'Silver', 'mileage' => 18000, 'engine_type' => 'V8', 'fuel_type' => 'LPG', 'transmission' => 'Automatic', 'body_style' => 'Sedan', 'drive_train' => 'FWD', 'condition' => 'Used', 'location' => 'Seoul', 'options' => json_encode(['Sunroof', 'Leather Seats']), 'status' => 'Available', 'additional_notes' => 'Well maintained, single owner.', 'added_by' => 1],
            ['make' => 'Ford', 'model' => 'Mustang', 'year' => 2021, 'vin' => '2NG-CM82633A004312', 'value' => 28000, 'currency' => 'USD', 'color' => 'Red', 'mileage' => 1507600, 'engine_type' => 'V6', 'fuel_type' => 'Gasoline', 'transmission' => 'Manual', 'body_style' => 'Hatchback', 'drive_train' => 'FWD', 'condition' => 'Used', 'location' => 'Chonnam', 'options' => json_encode(['Sunroof', 'Leather Seats, Keyless']), 'status' => 'Available', 'additional_notes' => 'Well maintained, single owner.', 'added_by' => 1],
            ['make' => 'Chevrolet', 'model' => 'Malibu', 'year' => 2018, 'vin' => '7HG-CM82633A004322', 'value' => 34000, 'currency' => 'USD', 'color' => 'Blue', 'mileage' => 515000, 'engine_type' => 'V6', 'fuel_type' => 'Diesel', 'transmission' => 'Automatic', 'body_style' => 'Sedan', 'drive_train' => 'FWD', 'condition' => 'New', 'location' => 'New York, NY', 'options' => json_encode(['Sunroof', 'Leather Seats']), 'status' => 'Available', 'additional_notes' => 'Brand New.', 'added_by' => 1],
            ['make' => 'Nissan', 'model' => 'Altima', 'year' => 2022, 'vin' => '5HG-CM82633A004352', 'value' => 12000, 'currency' => 'KRW', 'color' => 'Ash', 'mileage' => 15540, 'engine_type' => '4 Cylinder', 'fuel_type' => 'Gasoline', 'transmission' => 'Automatic', 'body_style' => 'SUV', 'drive_train' => '4WD', 'condition' => 'Used', 'location' => 'New York, NY', 'options' => json_encode(['Sunroof', 'Leather Seats']), 'status' => 'Available', 'additional_notes' => 'Well maintained, single owner.', 'added_by' => 1],
            ['make' => 'BMW', 'model' => 'X5', 'year' => 2023, 'vin' => '3HG-CM82633A004352', 'value' => 45000, 'currency' => 'EUR', 'color' => 'Black', 'mileage' => 5000, 'engine_type' => 'V8', 'fuel_type' => 'Diesel', 'transmission' => 'Automatic', 'body_style' => 'SUV', 'drive_train' => 'AWD', 'condition' => 'New', 'location' => 'Berlin', 'options' => json_encode(['Sunroof', 'Leather Seats', 'Navigation System']), 'status' => 'Available', 'additional_notes' => 'Brand New.', 'added_by' => 1],
            ['make' => 'Kia', 'model' => 'Sorento', 'year' => 2021, 'vin' => '9HG-CM82633A004352', 'value' => 32000, 'currency' => 'KRW', 'color' => 'White', 'mileage' => 30000, 'engine_type' => 'V6', 'fuel_type' => 'Gasoline', 'transmission' => 'Automatic', 'body_style' => 'SUV', 'drive_train' => 'AWD', 'condition' => 'Used', 'location' => 'Seoul', 'options' => json_encode(['Sunroof', 'Leather Seats']), 'status' => 'Available', 'additional_notes' => 'Well maintained, single owner.', 'added_by' => 1],
            ['make' => 'Audi', 'model' => 'A4', 'year' => 2020, 'vin' => '4HG-CM82633A004352', 'value' => 38000, 'currency' => 'GBP', 'color' => 'Grey', 'mileage' => 20000, 'engine_type' => 'V6', 'fuel_type' => 'Diesel', 'transmission' => 'Automatic', 'body_style' => 'Sedan', 'drive_train' => 'FWD', 'condition' => 'Used', 'location' => 'London', 'options' => json_encode(['Sunroof', 'Leather Seats', 'Bluetooth']), 'status' => 'Available', 'additional_notes' => 'Well maintained, single owner.', 'added_by' => 1],
            ['make' => 'Mercedes-Benz', 'model' => 'C-Class', 'year' => 2019, 'vin' => '6HG-CM82633A004352', 'value' => 41000, 'currency' => 'EUR', 'color' => 'Silver', 'mileage' => 25000, 'engine_type' => 'V8', 'fuel_type' => 'Gasoline', 'transmission' => 'Automatic', 'body_style' => 'Sedan', 'drive_train' => 'RWD', 'condition' => 'Used', 'location' => 'Munich', 'options' => json_encode(['Sunroof', 'Leather Seats', 'Navigation System']), 'status' => 'Available', 'additional_notes' => 'Well maintained, single owner.', 'added_by' => 1],
            ['make' => 'Hyundai', 'model' => 'Elantra', 'year' => 2022, 'vin' => '8HG-CM82633A004352', 'value' => 22000, 'currency' => 'KRW', 'color' => 'Blue', 'mileage' => 10000, 'engine_type' => '4 Cylinder', 'fuel_type' => 'Gasoline', 'transmission' => 'Automatic', 'body_style' => 'Sedan', 'drive_train' => 'FWD', 'condition' => 'New', 'location' => 'Busan', 'options' => json_encode(['Sunroof', 'Leather Seats']), 'status' => 'Available', 'additional_notes' => 'Brand New.', 'added_by' => 1],
        ];

        foreach ($cars as $car) {
            \App\Models\Car::create($car);
        }
    }
}
