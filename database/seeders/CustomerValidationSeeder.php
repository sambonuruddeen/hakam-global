<?php

namespace Database\Seeders;

use App\Models\CustomerValidation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerValidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 20 sample customers
        for ($i = 0; $i < 10; $i++) {
            CustomerValidation::create([
                'account_number'        => $faker->unique()->numerify('ACCT#####'),
                'account_name'          => $faker->name,
                'address'               => $faker->address,
                'phone_number'          => $faker->phoneNumber,
                'email'                 => $faker->unique()->safeEmail,
                'latitude'              => $faker->latitude,
                'longitude'             => $faker->longitude,
                'customer_type'         => $faker->randomElement(['Prepaid', 'Postpaid']),
                'meter_number'          => $faker->unique()->numerify('MTR#####'),
                'meter_status'          => $faker->randomElement(['Good', 'Faulty', 'None']),
                'last_vending_date'     => $faker->date(),
                'billing_type'          => $faker->randomElement(['Metered', 'Estimation']),
                'bill_delivery_method'  => $faker->randomElement(['SMS', 'Hard-Copy', 'None']),
                'last_bill_payment_date' => $faker->date(),
                'transformer_id'        => $faker->numberBetween(1, 5),
                'new_customer'          => $faker->randomElement(['Illegal Connection', 'Not Connected', 'None']),
                'remarks'               => $faker->sentence,
                'status'                => $faker->randomElement(['Approved', 'Rejected', 'Pending']),
                'supervisor_remarks'    => $faker->sentence,
                'photo'                 => null, // or use $faker->imageUrl()
                'created_by'            => $faker->numberBetween(1, 3), // Assuming user IDs exist
            ]);
        }
    }
}
