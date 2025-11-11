<?php

namespace Database\Seeders;

use App\Models\CustomerValidation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\TechnicalAssetsTableSeeder;
use Database\Seeders\StateSeeder;
use Database\Seeders\BusinessUnitSeeder;
use Database\Seeders\Feeder11Seeder;
use Database\Seeders\Feeder33Seeder;
use Database\Seeders\TransformerSeeder;


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
            TechnicalAssetsTableSeeder::class,
            StateSeeder::class,
            BusinessUnitSeeder::class,
            Feeder11Seeder::class,
            Feeder33Seeder::class,
            TransformerSeeder::class,
            CustomerValidationSeeder::class,
        ]);
    }
}
