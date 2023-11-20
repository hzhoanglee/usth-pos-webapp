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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code', 191)->nullable()->default(null);
            $table->float('value',8,2)->nullable()->default(null);
            $table->date('started_date')->nullable()->default(null);
            $table->date('expired_date')->nullable()->default(null);
            $table->string('coupon_type')->nullable()->default(null);
            $table->string('coupon_condition')->nullable()->default(null);
            $table->string('coupon_value')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
