<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TechnicalAssets;
use App\Models\TechnicalAssetsCondition;

class TechnicalAssetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $assets = [
            'HT Wooden Pole' => ['Weak', 'Rotten', 'Good'],
            'HT Concrete Pole' => ['Cracked', 'Leaning', 'Good'],
            'HT Alluminium Conductor' => ['Undersized',	'Multiple-joined', 'Good'],
            'Wooden Cross Arms' => ['Weak','Rotten','Good'],
            'Tie Straps' => ['Weak/U-shape','Bad','Good'],
            'Stay Support' => ['Vandalised', 'Available-Weak', 'Available-Good'],
            'HT Jumpers' => ['Weak','Undersized','Good'],
            'LT Concrete Pole' => ['Cracked','Leaning','Good'],
            'LT Wooden Poles' => ['Weak','Rotten','Good'],
            'Incomer Cable' => ['Burnt-Weak	Burnt','Bad','Good'],
            'LT Alluminium Conductor' => ['Undersized',	'Multiple-joined','Good'],
            'Copper Earth Wire' => ['Vandalised','Available-Weak','Available-Good'],
            'D\' Fittings' => ['Shattered','Bad','Good'],
            'Lightening Arrestors' => ['Shattered','Bad','Good'],
            'Pot Insulators' => ['Flashed','Cracked','Good'],
            'Feeder Pillar' => ['Weak','Bad','Good'],
            'LT Upriser Cable' => ['Burnt-Weak','Burnt-Bad','Good'],
            'Disc Insulators' => ['Cracked','Good'],
            'LT Overhead Line' => ['Sagged','Straight/Good'],
            'Substation Fencing' => ['Yes','No'],
            'Fire Cross Arms' => ['Bad','Good'],
            'HT Overhead Lines' => ['Sagged', 'Straight/Good'],
            'Substation Gravelling' => ['Yes','No'],
            'Feeder Metering ' => ['Metered','Not Metered'],
            'Feeder Meter Status' => ['Faulty','Good'],
            'Feeder Meter Communication Status' => ['Active','Inactive'],
            'DT Metering ' => ['Metered', 'Not Metered'],
            'DT Meter Status' => ['Faulty', 'Good'],
            'DT Meter Communication Status' => ['Active','Inactive'],
        ];

        foreach ($assets as $asset => $value) {
             $asset_key = DB::table('technical_assets')->insertGetId([
                'name' => $asset,
                'description' => null
            ]);
            
            //  TechnicalAssets::create([
            //     'name' => $asset,
            //     'description' => null
            // ]);
            
            
            foreach($value as $key => $item) {
                TechnicalAssetsCondition::create([
                    'name' => $item,
                    'asset_id' => $asset_key,
                ]);
            }
        }

    }
}
