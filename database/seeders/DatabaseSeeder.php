<?php

namespace Database\Seeders;

use App\Models\CustomerValidation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;
// use Data


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seeders
        $this->call([
            UserTableSeeder::class,
            \Database\Seeders\VendorsTableSeeder::class,
            \Database\Seeders\MakesTableSeeder::class,
            \Database\Seeders\CarModelsTableSeeder::class,
            // \Database\Seeders\CarsTableSeeder::class,
            \Database\Seeders\CarListingsTableSeeder::class,
            \Database\Seeders\CarOrdersTableSeeder::class,
            \Database\Seeders\ShipmentsTableSeeder::class,
            // \Database\Seeders\ShipmentItemsTableSeeder::class,
            
        ]);
    }
}