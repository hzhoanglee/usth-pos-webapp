<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $screen = $request->screen;
        $products = \App\Models\Product::all();
        $customers = \App\Models\Customer::select('id', 'name', 'mobile')->get();
        notyf()->position('x', 'right')
            ->position('y', 'top')->addSuccess('Hi, Have a nice day!');
        return view('pos.app', compact('screen', 'products', 'customers'));
    }

    public function getCustomerInfo(Request $request): \Illuminate\Http\JsonResponse
    {
        $details = [];
        $customer = \App\Models\Customer::find($request->id);
        foreach ($customer->details as $detail) {
            $details[$detail['type']] = $detail['Value'];
        }
        $customer = $customer->toArray();
        $customer['details'] = $details;
        return response()->json($customer);
    }
}
