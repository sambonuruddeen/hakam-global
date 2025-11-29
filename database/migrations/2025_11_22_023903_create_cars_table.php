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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('vin')->unique();
            $table->string('make');
            $table->string('model');
            $table->year('year');
            $table->decimal('value', 15, 2);
            $table->string('currency', 3)->default('USD'); // ISO currency code e,g Naira - NGN, US Dollar - USD, Korean Won - KRW
            $table->string('color')->nullable();
            $table->integer('mileage')->nullable();
            $table->string('engine_type')->nullable(); // e.g., V6, Electric
            $table->string('fuel_type')->nullable(); // e.g., Gasoline, Diesel, Electric
            $table->string('transmission')->nullable(); // e.g., Automatic, Manual  
            $table->string('body_style')->nullable(); // e.g., Sedan, SUV, Truck
            $table->string('drive_train')->nullable(); // e.g., FWD, RWD, AWD
            $table->string('condition')->nullable(); // e.g., New, Used, Certified Pre-Owned
            $table->string('location')->nullable();
            $table->string('options')->nullable(); // e.g., Sunroof, Leather Seats
            $table->enum('status', ['Available', 'Sold', 'Reserved'])->default('Available');
            $table->text('additional_notes')->nullable();
            $table->foreignId('added_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
