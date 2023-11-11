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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->string('role_code');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

        \Illuminate\Support\Facades\DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'role_code' => 'user_admin',
            ],
            [
                'role_name' => 'Manager',
                'role_code' => 'user_manager',
            ],
            [
                'role_name' => 'Cashier',
                'role_code' => 'user_cashier',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists('roles');
    }
};
