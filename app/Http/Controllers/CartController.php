<?php

namespace App\Http\Controllers;

use App\Events\NewProductToCart;
use App\Models\BankAccount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $screen = $request->screen;
        notyf()->position('x', 'right')
            ->position('y', 'top')->addSuccess('Hi, Have a nice day!');
        return view('cart.screen', compact('screen'));
    }

    public function addToCartRoute(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->addProductToCart($request->screen_id, $request->product_id, $request->cart_id, $request->selling_type);
        return response()->json($response, $response['code']);
    }

    public function addToCartByCode(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $product_id = Product::where('barcode', $request->barcode)->first();
            $response = $this->addProductToCart($request->screen_id, $product_id->id, $request->cart_id, $request->selling_type);
            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 500);
        }
    }

    public function clearCartRoute(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->clearCart($request->cart_id);
        event(new \App\Events\NewProductToCart($request->cart_id, 1));
        return response()->json($response, $response['code']);
    }

    public function removeCartItem(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->removeFromCart($request->screen_id, $request->product_id, $request->cart_id, $request->selling_type);
        return response()->json($response, $response['code']);
    }

    public function loadCart($cart_id): \Illuminate\Http\JsonResponse
    {
        $cart = $this->getCart(intval($cart_id));
        return response()->json($cart);

    }

    public function loadScreen($screen_id): \Illuminate\Http\JsonResponse
    {
        $cart = $this->getScreen(intval($screen_id));
        return response()->json($cart);
    }

    public function searchProduct(Request $request) {
        $name = $request->name;
        $product = Product::where('product_name','LIKE',"%$name%")->orwhere('barcode','LIKE',"%$name%")->get();
        return response()->json($product);
    }

    public function loadTotal($cart_id): \Illuminate\Http\JsonResponse
    {
        $value = $this->getCartSubtotal($cart_id);
        return response()->json($value);

    }

    public function generateCheckout(Request $request) {
        $cart = $this->getCart(intval($request->cart_id));

    }

    public function generateQr(Request $request): \Illuminate\Http\JsonResponse
    {
        $cart_id = $request->cart_id;
        $screen_id = $request->screen_id;
        $cart_value = $this->getCartSubtotal($cart_id);
        $amount = $cart_value['data']['total_due'];
        $bank_id = BankAccount::first()->id;
        $qr = TransactionController::dispQr($amount, $bank_id);
        event(new \App\Events\PushScreenData($screen_id, 'new_qr', base64_encode($qr['qr'])));
        return response()->json(['status' => true, 'needle'=> $qr['needle']], 200);
    }

    // action functions
    private function addProductToCart($screen_id, $product_id, $cart_id, $product_type): array
    {
        try {
            $product = Product::find($product_id);
            $cart_id = intval($cart_id);
            $product_type = intval($product_type);
            $screen_id = intval($screen_id);
            if (!$product) {
                return ['status' => 'false', 'message' => 'Product not found!', 'code' => 404];
            }
            if ($product_type != 0 && $product_type != 1) {
                return ['status' => 'false', 'message' => 'Invalid selling type!', 'code' => 400];
            }
            $cart = Cache::get('cart_' . $cart_id);
        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
        }
        try {
            if (!$cart) {
                if ($product_type == 0) {
                    $price = $product->price_box_discounted;
                } else {
                    $price = $product->price_item_discounted;
                }
                $cart[$product_id][$product_type] = [
                    "name" => $product->product_name,
                    "quantity" => 1,
                    "price" => $price,
                    "photo" => $product->product_image,
                    'tax' => $product->tax
                ];

            } else {
                if (isset($cart[$product_id][$product_type])) {
                    $cart[$product_id][$product_type]['quantity']++;
                } else {
                    if ($product_type == 0) {
                        $price = $product->price_box_discounted;
                    } else {
                        $price = $product->price_item_discounted;
                    }
                    $cart[$product_id][$product_type] = [
                        "name" => $product->product_name,
                        "quantity" => 1,
                        "price" => $price,
                        "photo" => $product->product_image,
                        'tax' => $product->tax
                    ];
                }

            }
        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
        }

        Cache::put('cart_' . $cart_id, $cart);
        $cart_quantity = 0;
        if (array_key_exists(0, $cart[$product_id])) {
            $cart_quantity = $cart[$product_id][0]['quantity'];
        }
        if (array_key_exists(1, $cart[$product_id])) {
            $cart_quantity += $cart[$product_id][1]['quantity'];
        }
//        $this->placeProductHold($product_id, $cart_quantity);
        Log::info('New product added to cart: ' . $product_id . ' - ' . $product_type . ' - ' . $cart_id . ' - ' . $screen_id);
        event(new \App\Events\NewProductToCart($cart_id, $screen_id));
        return ['status' => 'success', 'message' => 'Product added to cart successfully!', 'code' => 200];
    }

    private function removeFromCart($screen_id, $product_id, $cart_id, $product_type)
    {
        try {
            $cart = Cache::get('cart_' . $cart_id);
            if (!$cart) {
                return ['status' => 'false', 'message' => 'Cart not found!', 'code' => 404];
            }
            if ($product_type != 0 && $product_type != 1) {
                return ['status' => 'false', 'message' => 'Invalid selling type!', 'code' => 400];
            }
            if (!isset($cart[$product_id][$product_type])) {
                return ['status' => 'false', 'message' => 'Product not found in cart!', 'code' => 404];
            }
            unset($cart[$product_id][$product_type]);
            if (count($cart[$product_id]) == 0) {
                unset($cart[$product_id]);
            }
            Cache::put('cart_' . $cart_id, $cart);
            event(new \App\Events\NewProductToCart($cart_id, $screen_id));
            // TODO: product hold
            return ['status' => 'success', 'message' => 'Product removed from cart successfully!', 'code' => 200];

        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
        }

    }

    private function getCart($cart_id)
    {
        return Cache::get('cart_' . $cart_id);
    }

    private function clearCart($cart_id): array
    {
        Cache::forget('cart_' . $cart_id);
        return ['status' => 'success', 'message' => 'Cart cleared successfully!', 'code' => 200];
    }

    private function getScreen($screen_id)
    {
        return Cache::get('screen_' . $screen_id);
    }

    private function placeProductHold($product_id, $quantity) {
        $current_hold = $this->getProductHold($product_id);
        if ($current_hold == 0) {
            $current_hold = $quantity;
        } else {
            $current_hold += $quantity;
        }
        Cache::put('hold_' . $product_id, $current_hold, 60 * 24 * 7);
    }

    private function getProductHold($product_id)
    {
        $hold = Cache::get('hold_' . $product_id);
        if (!$hold) {
            return 0;
        }
        return $hold;
    }

    private function getCartSubtotal($cart_id): array
    {
        $cart_value = [
            'subtotal' => 0,
            'vat' => 0,
            'total' => 0,
            'total_due' => 0
        ];
        // get cart
        $cart = $this->getCart(intval($cart_id));
        if ($cart == null){
            return ['status' => 'success', 'data' => $cart_value, 'message' => 'ok!', 'code' => 200];
        }

        foreach ($cart as $product) {
            if (array_key_exists(1, $product)) {
                $sub_total = $product[1]['quantity'] * $product[1]['price'];
                $vat = $sub_total * ($product[1]['tax'] / 100);
                $total = $vat + $sub_total;
                $total_due = $total;
                $cart_value['subtotal'] += $sub_total;
                $cart_value['vat'] += $vat;
                $cart_value['total'] += $total;
                $cart_value['total_due'] += $total_due;

            }
            if (array_key_exists(0, $product)) {
                $sub_total = $product[0]['quantity'] * $product[0]['price'];
                $vat = $sub_total * ($product[0]['tax'] / 100);
                $total = $vat + $sub_total;
                $total_due = $total;
                $cart_value['subtotal'] += $sub_total;
                $cart_value['vat'] += $vat;
                $cart_value['total'] += $total;
                $cart_value['total_due'] += $total_due;
            }
        }
        $cart_value['subtotal'] = ceil($cart_value['subtotal']);
        $cart_value['vat'] = ceil($cart_value['vat']);
        $cart_value['total'] = ceil($cart_value['total']);
        $cart_value['total_due'] = ceil($cart_value['total_due']);
        return ['status' => 'success', 'data' => $cart_value, 'message' => 'ok!', 'code' => 200];
    }

    private function doCheckOut($cart_id, $customer, $payment) {
        // TODO: This is POC only, need to be implemented
        $cart = $this->getCart(intval($cart_id));
        $cart_value = $this->getCartSubtotal($cart_id);
        if(array_key_exists('type', $customer)) {
            // 1: new, 2: old, 3: guest
            if ($customer['type'] == 1) {
                $customer_id = $this->createCustomer($customer['data']);
            } else if ($customer['type'] == 2) {
                $customer_id = $customer['id'];
            } else {
                $customer_id = null;
            }
        } else {
            $customer_id = null;
        }
        $order = new \App\Models\Order();
        $order->cart_id = $cart_id;
        $order->customer_id = $customer_id;
        $order->price_before_discount = $cart_value['data']['subtotal'];
        $order->apply_coupons = 0;
        $order->price_after_discount = $cart_value['data']['total'];
        $order->status = 1;
        $order->user_id = auth()->id();
        $order->order_date = now();
        $order->payment_method = $payment['method'];
        $order->payment_status = $payment['status'];
        $order->transaction_id = $payment['transaction_id'];
        $order->save();
        $order_id = $order->id;
        foreach ($cart as $product) {
            if (array_key_exists(1, $product)) {
                $order_detail = new \App\Models\OrderDetail();
                $order_detail->order_id = $order_id;
                $order_detail->product_id = $product[1]['id'];
                $order_detail->quantity = $product[1]['quantity'];
                $order_detail->price = $product[1]['price'];
                $order_detail->save();
            }
            if (array_key_exists(0, $product)) {
                $order_detail = new \App\Models\OrderDetail();
                $order_detail->order_id = $order_id;
                $order_detail->product_id = $product[0]['id'];
                $order_detail->quantity = $product[0]['quantity'];
                $order_detail->price = $product[0]['price'];
                $order_detail->save();
            }
        }

    }

    private function generateBankQrCode($cart_id, $screen_id) {

    }

    private function createCustomer($customer) {
        $customer = new \App\Models\Customer();
        $customer->name = $customer['name'];
        $customer->phone = $customer['phone'];
        $customer->email = $customer['email'];
        $customer->face = "";
        $customer->address = $customer['address'];
        $customer->zalo_number = $customer['zalo_number'];
        $customer->credit = 0;
        $customer->age = $customer['age'];
        foreach ($customer['fields'] as $key => $value) {
            $customer->details[$key] = $value;
        }
        $customer->save();
        return $customer->id;
    }

    // playground
    public function playground(Request $request)
    {

    }
}
