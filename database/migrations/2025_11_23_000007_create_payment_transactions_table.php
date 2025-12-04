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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_type', ['Car Purchase', 'Shipping']);
            $table->bigInteger('related_id');
            $table->string('related_type'); // 'App\Models\CarOrder' or 'App\Models\Shipment'
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('NGN');
            $table->enum('payment_status', ['Pending', 'Completed', 'Cancelled', 'Refunded'])->default('Pending');
            $table->string('payment_method')->nullable(); // Credit Card, Bank Transfer, etc.
            $table->date('payment_date')->nullable();
            $table->string('reference_number')->unique()->nullable(); // Invoice/Transaction ID
            $table->text('notes')->nullable();
            $table->timestamps();

            // Index for polymorphic queries
            $table->index(['related_type', 'related_id']);
            $table->index('transaction_type');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
