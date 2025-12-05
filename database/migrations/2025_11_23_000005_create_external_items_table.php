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
        Schema::create('external_items', function (Blueprint $table) {
            $table->id();
            $table->string('vin')->unique();
            $table->string('description')->nullable();
            $table->string('color');
            $table->string('condition');
            $table->string('mileage')->nullable();
            $table->string('car_model_id');
            $table->integer('year');
            $table->decimal('price', 15, 2);
            $table->string('currency', 3)->default('NGN');
            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('source_info')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_items');
    }
};
