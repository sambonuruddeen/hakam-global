<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $shipments = [
            ['shipping_company' => 2, 'container_type' => '40ft', 'container_number' => 'yt88756', 'tracking_number' => 'yy7756a', 'origin' => 'Incheon', 'destination' => 'Lagos', 'shipment_date' => '2025-12-10', 'delivery_date' => '', 'status' => 'at_port'],
            
        ];
    }
}
