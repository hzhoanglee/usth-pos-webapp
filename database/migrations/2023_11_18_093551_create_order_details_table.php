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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->float('Subtotal', 8, 2)->nullable()->default(null);
            $table->string('Quantity',191)->nullable()->default(null);
            $table->enum('status', ['OK', 'Refund'])->default('OK');
            $table->foreignId('OrderID')->nullable()->default(null)->constrained('orders');
            $table->foreignId('ProductID')->nullable()->default(null)->constrained('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
