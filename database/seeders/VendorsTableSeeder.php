<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Vendor Types: enum('Dealer','Supplier','Auction House','Individual')
        // payment_terms: means of payment terms like 'Net 30', 'Prepaid', etc.
        $vendors = [
            ['name' => 'AutoWorld Supplies', 'vendor_type' => 'Supplier', 'contact_person' => 'John Doe', 'email' => 'supplier@hakamglobal.com', 'phone' => '123-456-7890', 'address' => '123 Supply St, Cityville', 'city' => 'Cityville', 'state' => 'Stateville', 'country' => 'Countryland', 'payment_terms' => 'Net 30', 'status' => 'Active'],
            ['name' => 'Premium Auto Dealers', 'vendor_type' => 'Dealer', 'contact_person' => 'Jane Smith', 'email' => 'dealer@hakamglobal.com', 'phone' => '987-654-3210', 'address' => '456 Dealer Ave, Townsville', 'city' => 'Townsville', 'state' => 'Stateville', 'country' => 'Countryland', 'payment_terms' => 'Net 15', 'status' => 'Active'],
            ['name' => 'City Auction House', 'vendor_type' => 'Auction House', 'contact_person' => 'Mike Johnson', 'email' => 'auction@hakamglobal.com', 'phone' => '555-123-4567', 'address' => '789 Auction Rd, Villagetown', 'city' => 'Villagetown', 'state' => 'Stateville', 'country' => 'Countryland', 'payment_terms' => 'Due on Receipt', 'status' => 'Active'],
            ['name' => 'Individual Seller - Alex Brown', 'vendor_type' => 'Individual', 'contact_person' => 'Alex Brown', 'email' => 'individual@hakamglobal.com', 'phone' => '444-555-6666', 'address' => '321 Individual Ln, Hamletcity', 'city' => 'Hamletcity', 'state' => 'Stateville', 'country' => 'Countryland', 'payment_terms' => 'Prepaid', 'status' => 'Active'],
        ];
        
        foreach ($vendors as $vendor) {
           \App\Models\Vendor::create($vendor);
        }
    }
}
