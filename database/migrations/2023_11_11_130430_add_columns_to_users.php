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
        Schema::table('users', function (Blueprint $table) {
            $table->after('password', function ($table) {
                $table->string('username', 50)->nullable()->default(null);
                $table->string('phone', 20)->nullable()->default(null);
                $table->string('address', 255)->nullable()->default(null);
                $table->string('avatar', 255)->nullable()->default(null);
                $table->integer('national_id')->nullable()->default(null);
                $table->string('employee_id',20)->nullable()->default(null);
            });

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'phone',
                'address',
                'avatar',
                'national_id',
                'employee_id',
            ]);
        });
    }
};
