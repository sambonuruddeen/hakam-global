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
        Schema::create('car_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_model_id')->constrained('car_models', 'id')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->string('vin')->unique();
            $table->string('color')->nullable();
            $table->integer('mileage')->nullable();
            $table->string('condition')->default('Used'); // New, Used, Certified Pre-Owned
            $table->decimal('price', 15, 2);  // Per-car pricing
            $table->string('currency', 3)->default('NGN');
            $table->enum('status', ['Available', 'Sold', 'Reserved', 'In Transit'])->default('Available');
            $table->string('location')->nullable();
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_listings');
    }
};
