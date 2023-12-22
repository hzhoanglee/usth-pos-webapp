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

    public function checkUserFace(Request $request)
    {
        $screen_id = $request->pos_screen;
        $image = $request->image;
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $image = base64_decode($image);
        $tmp_file = tempnam(sys_get_temp_dir(), 'pos');
        file_put_contents($tmp_file, $image);
        $client = new \GuzzleHttp\Client();

        $request = $client->request('POST', 'http://127.0.0.1:5500/check-face', [
            'multipart' => [
                [
                    'name'     => 'File1',
                    'contents' => fopen($tmp_file, 'r'),
                ],
                [
                    'name'     => 'pos_screen',
                    'contents' => $screen_id,
                ],
            ],
        ]);
        unlink($tmp_file);
        $response = $request->getBody()->getContents();
        return response()->json($response);


    }

}
