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
        Schema::create('car_shipments', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('car_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('external_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('shipment_id')->constrained()->onDelete('cascade');
            $table->primary(['car_order_id', 'external_item_id', 'shipment_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_shipments');
    }
};
