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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipping_company');
            $table->string('container_type'); // e.g., '20ft', '40ft'
            $table->string('container_number')->unique()->nullable(); // if different from tracking number
            $table->string('tracking_number')->unique();
            $table->string('origin');
            $table->string('destination');
            $table->date('shipment_date');
            $table->date('delivery_date')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
