<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApplyRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:apply-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
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
}
