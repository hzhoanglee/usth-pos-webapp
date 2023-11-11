<?php

namespace App\Http\Controllers;

use Filament\Facades\Filament;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logOut(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        \Auth::logout();
        return redirect(Filament::getLoginUrl());
    }


}
