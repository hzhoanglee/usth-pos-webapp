<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $screen = $request->screen;
        $products = \App\Models\Product::all();
        notyf()->position('x', 'right')
            ->position('y', 'top')->addSuccess('Hi, Have a nice day!');
        return view('pos.app', compact('screen', 'products'));
    }
}
