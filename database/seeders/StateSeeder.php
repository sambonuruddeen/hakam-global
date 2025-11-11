<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            'Plateau',
            'Bauchi',
            'Gombe',
            'Benue', // If you meant the state, replace with 'Benue'
        ];

        foreach ($states as $name) {
            State::firstOrCreate(['name' => $name]);
        }
    }
}
