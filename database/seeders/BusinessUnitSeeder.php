<?php

namespace Database\Seeders;

use App\Models\BusinessUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $units = [
            ['name' => 'JOS METRO', 'state_id' => 1],
            ['name' => 'MAKURDI',  'state_id' => 4],
            ['name' => 'GBOKO',    'state_id' => 4],
            ['name' => 'BUKURU',   'state_id' => 1],
            ['name' => 'OTUKPO',   'state_id' => 4],
            ['name' => 'BAUCHI',   'state_id' => 2],
            ['name' => 'AZARE',    'state_id' => 2],
            ['name' => 'GOMBE',    'state_id' => 3],
        ];

        // The following upsert assumes that the 'name' column is unique in the database schema:
        BusinessUnit::upsert($units, ['name'], ['state_id']);
    }
}
