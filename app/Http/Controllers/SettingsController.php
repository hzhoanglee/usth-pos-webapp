<?php

namespace App\Http\Controllers;

use App\Models\Settings;

class SettingsController extends Controller
{
    public function getPassword(){
//        $password = Settings::all();
        $password = Settings::pluck('unlock_password');
        return $password;
    }

}
