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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id', 50)->nullable()->default(null);
            $table->string('cashier_id', 50)->nullable()->default(null);
            $table->json('carts', 50)->nullable()->default(null);
            $table->string('payment_type', 50)->nullable()->default(null);
            $table->string('payment_record', 50)->nullable()->default(0);
            $table->json('value')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
