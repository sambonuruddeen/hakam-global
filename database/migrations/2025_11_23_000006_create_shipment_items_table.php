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
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete();
            $table->string('item_type'); // 'App\Models\CarOrder' or 'App\Models\ExternalItem'
            $table->bigInteger('item_id');
            $table->string('custom_description', 1000)->nullable();
            $table->decimal('custom_price', 15, 2)->nullable();
            $table->string('custom_currency', 3)->nullable();
            $table->timestamps();

            // Unique constraint: can't add same item twice to same shipment
            $table->unique(['shipment_id', 'item_type', 'item_id']);

            // Index for polymorphic queries
            $table->index(['item_type', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_items');
    }
};
