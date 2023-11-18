<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema as SchemaAlias;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        SchemaAlias::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->default(null);
            $table->string('mobile', 200)->nullable()->default(null);
            $table->string('email', 200)->nullable()->default(null);
            $table->json('details')->nullable();
            $table->string('face', 2000)->default(null);
            $table->string('address', 200)->nullable()->default(null);
            $table->string('zalo_number', 200)->nullable()->default(null);
            $table->float('credit', 200)->nullable()->default(null);
            $table->integer('age', 20)->nullable()->default(null);
            $table->string('image', 200)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        SchemaAlias::dropIfExists('customers');
    }
};
