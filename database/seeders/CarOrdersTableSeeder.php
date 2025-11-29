<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Order Status: enum('Requested','Purchase Confirmed','Awaiting Pickup','Queued for Shipment')
        // user_id to buyer id
        $orders = [
            ['car_listing_id' => 1, 'user_id' => 1, 'purchase_price' => '1200556', 'purchase_currency' => 'USD', 'order_status' => 'Purchase Confirmed', 'purchase_date' => '2024-01-15', 'shipment_id' => null],
            ['car_listing_id' => 2, 'user_id' => 2, 'purchase_price' => '2200556', 'purchase_currency' => 'USD', 'order_status' => 'Requested', 'purchase_date' => '2024-02-20', 'shipment_id' => null],
            ['car_listing_id' => 3, 'user_id' => 3, 'purchase_price' => '3200556', 'purchase_currency' => 'USD', 'order_status' => 'Awaiting Pickup', 'purchase_date' => '2024-03-25', 'shipment_id' => null],

        
        ];

        foreach ($orders as $order) {
            \App\Models\CarOrders::create($order);
        }
    }
}
