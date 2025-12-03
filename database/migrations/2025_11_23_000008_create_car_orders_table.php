<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_orders', function (Blueprint $table) {
            $table->id();

            // Foreign key to the user who placed the order
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Link to car_listings table instead of storing car details directly
            $table->foreignId('car_listing_id')
                ->nullable()
                ->constrained('car_listings')
                ->onDelete('set null');

            // Purchase details
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->string('purchase_currency', 3)->default('NGN');

            // Status in the request/queuing phase
            $table->enum('order_status', [
                'Requested',
                'Purchase Confirmed',
                'Awaiting Pickup',
                'Queued for Shipment',
                'Cancelled'
            ])->default('Requested');

            // Optional: Date the order was officially confirmed/paid for
            $table->date('purchase_date')->nullable();

            // Foreign key link to the actual shipment once it begins
            $table->foreignId('shipment_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->timestamps();

            // Enforce one purchase order per car listing
            $table->unique('car_listing_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_orders');
    }
};
