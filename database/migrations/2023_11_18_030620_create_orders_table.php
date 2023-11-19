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
            $table->date('date');
            $table->float('price_before_discount', 8, 2)->nullable()->default(null);
            $table->float('price_after_discount', 8, 2)->nullable()->default(null);
            $table->string('apply_coupons', 191)->nullable()->default(null);
            $table->enum('status', ['OK', 'Refund', 'Partly Refund'])->default('OK');
            $table->timestamps();
            $table->foreignId('cashier_name')->nullable()->default(null)->constrained('users');
            $table->enum('client', ['Walk-in Customer', 'Registered Customer'])->default('OK');

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
