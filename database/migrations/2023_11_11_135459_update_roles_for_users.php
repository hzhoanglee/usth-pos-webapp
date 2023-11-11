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
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            if($user->email == "admin@vhz.io") {
                $user->role_id = \App\Models\Role::where('role_code', 'user_admin')->first()->id;
            } else {
                $user->role_id = \App\Models\Role::where('role_code', 'user_cashier')->first()->id;
            }
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
