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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('lot_code',191)->nullable()->default(null);
            $table->string('lot_name',191)->nullable()->default(null);
            $table->float('lot_price', 8, 2)->nullable()->default(null);
            $table->string('sku_code',191)->nullable()->default(null);
            $table->date('expired_date')->nullable()->default(null);
            $table->foreignId('imported_by')->nullable()->default(null)->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
