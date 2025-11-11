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
        Schema::create('customer_validations', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');
            $table->string('account_name');
            $table->string('address');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('customer_type', ['Postpaid', 'Prepaid', 'None'])->default('None');
            $table->string('meter_number')->nullable();
            $table->enum('meter_status', ['Good', 'Faulty', 'None'])->default('None');
            $table->string('last_vending_date')->nullable();
            $table->enum('billing_type', ['Metered', 'Estimation', 'None'])->nullable();
            $table->enum('bill_delivery_method', ['Hard-Copy', 'SMS', 'None'])->nullable();
            $table->date('last_bill_payment_date')->nullable();
            $table->string('transformer_id');
            $table->enum('new_customer', ['Illegal Connection', 'Not Connected', 'None'])->nullable();
            $table->text('remarks')->nullable();
            $table->string('photo');
            $table->enum('status', ['Approved', 'Rejected', 'Pending'])->default('Pending');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_validations');
    }
};
