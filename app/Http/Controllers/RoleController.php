<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function myRole() {
//        $user = \Auth::user()->with('role')->first();
        dd(__('manager.Admin'));

    }
}
