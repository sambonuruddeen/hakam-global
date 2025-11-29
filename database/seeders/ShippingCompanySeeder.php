<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $companys = [
            ['name' => 'Maersk Line', 'short_name' => 'Maersk', 'contact_number' => '234-567-8901', 'email' =>  ''],
            ['name' => 'Mediterranean Shipping Company', 'short_name' => 'MSC', 'contact_number' => '345-678-9012', 'email' =>  ''],
            ['name' => 'Hapag-Lloyd', 'short_name' => 'Hapag-Lloyd', 'contact_number' => '567-890-1234', 'email' =>  ''],
        ];
    }
}
