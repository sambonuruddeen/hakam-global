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
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('item_description')->nullable()->after('tracking_number');
            $table->string('vin')->unique()->nullable()->after('item_description');
            $table->decimal('item_value', 15, 2)->nullable()->after('vin');
            $table->string('currency', 3)->default('NGN')->after('item_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['item_description', 'vin', 'item_value', 'currency']);
        });
    }
};
