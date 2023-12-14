<?php

namespace App\Http\Controllers;

use App\Events\NewProductToCart;
use App\Models\BankAccount;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
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

    public function applyCoupon(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->applyCouponToCart($request->coupon_id, $request->cart_id);
        return response()->json($response, $response['code']);
    }

    public function getCouponList() {
        $coupons = $this->listCoupons();
        return response()->json($coupons);
    }

    public function generateCheckout(Request $request): \Illuminate\Http\JsonResponse
    {
        $cart_id = $request->cart_id;
        $customer_id = $request->customer_id;
        $payment_type = $request->payment_type;
        $payment_record = $request->payment_record;
        $coupon_id = $request->coupon_id;
        $response = $this->doCheckOut($cart_id, $customer_id, $payment_type, $payment_record, $coupon_id);
        return response()->json($response, $response['code']);

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
            $product_type = intval($product_type);
            $cart_id = intval($cart_id);
            $screen_id = intval($screen_id);
            if($product_type == 3) {
                $coupon_code = $product_id;
                $coupon = Coupon::where('coupon_code', $coupon_code)->first();
                if ($coupon == null) {
                    return ['status' => 'false', 'message' => 'Coupon not found!', 'code' => 404];
                }
            } else {
                $product = Product::find($product_id);
                if (!$product) {
                    return ['status' => 'false', 'message' => 'Product not found!', 'code' => 404];
                }
                if ($product_type != 0 && $product_type != 1) {
                    return ['status' => 'false', 'message' => 'Invalid selling type!', 'code' => 400];
                }
            }
            $cart = $this->getCart($cart_id);
        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
        }
        if($product_type == 3) {
            try {
                if (!$cart) {
                    return ['status' => 'false', 'message' => 'There is no product in cart', 'code' => 500];
                } else {
                    if (isset($cart[$product_id]) && isset($cart[$product_id][$product_type])) {
                        return ['status' => 'false', 'message' => 'Coupon is already applied', 'code' => 500];
                    }
                    $discount = $this->calculateDiscount($coupon, $cart_id);
                    $cart[$product_id][$product_type] = [
                        "name" => $coupon->coupon_code,
                        "quantity" => 1,
                        "price" => $discount['value'],
                        "photo" => "",
                        'tax' => 0,
                        'type' => $discount['type'],
                    ];
                }
            } catch (\Exception $e) {
                return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
            }
        } else {
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
                        'tax' => $product->tax,
                        'type' => (string)$product_type
                    ];

                } else {
                    if (isset($cart[$product_id][$product_type])) {
                        if($product->limit_per_order != 0) {
                            if($cart[$product_id][$product_type]['quantity'] >= $product->limit_per_order) {
                                return ['status' => 'false', 'message' => 'Only allow ' . $product->limit_per_order . ' product(s) per order!', 'code' => 500];
                            }
                        }
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
                            'tax' => $product->tax,
                            'type' => (string)$product_type
                        ];
                    }
                }
            } catch (\Exception $e) {
                return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
            }
        }

        $this->putCart($cart_id, $cart);
        if($product_type != 3) {
            $this->updateCouponValue($cart_id);
        }
//        $cart_quantity = 0;
//        if (array_key_exists(0, $cart[$product_id])) {
//            $cart_quantity = $cart[$product_id][0]['quantity'];
//        }
//        if (array_key_exists(1, $cart[$product_id])) {
//            $cart_quantity += $cart[$product_id][1]['quantity'];
//        }
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
            if ($product_type != 0 && $product_type != 1 && $product_type != 3) {
                return ['status' => 'false', 'message' => 'Invalid selling type!', 'code' => 400];
            }
            if (!isset($cart[$product_id][$product_type])) {
                return ['status' => 'false', 'message' => 'Product not found in cart!', 'code' => 404];
            }
            unset($cart[$product_id][$product_type]);
            if (count($cart[$product_id]) == 0) {
                unset($cart[$product_id]);
            }
            $this->putCart($cart_id, $cart);
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

    private function putCart($cart_id, $cart)
    {
        Cache::put('cart_' . $cart_id, $cart);
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
            'total_due' => 0,
            'discount' => 0,
        ];
        $cart = $this->getCart(intval($cart_id));
        if ($cart == null){
            return ['status' => 'success', 'data' => $cart_value, 'message' => 'ok!', 'code' => 200];
        }

        foreach ($cart as $product) {
            if (array_key_exists(1, $product)) {
                $sub_total = $product[1]['quantity'] * $product[1]['price'];
                $vat = $sub_total * ($product[1]['tax'] / 100);
                $cart_value['subtotal'] += $sub_total;
                $cart_value['vat'] += $vat;

            }
            if (array_key_exists(0, $product)) {
                $sub_total = $product[0]['quantity'] * $product[0]['price'];
                $vat = $sub_total * ($product[0]['tax'] / 100);
                $cart_value['subtotal'] += $sub_total;
                $cart_value['vat'] += $vat;
            }
            if(array_key_exists(3, $product)) {
                $cart_value['discount'] += $product[3]['price'];
            }
        }
        $cart_value['subtotal'] = ceil($cart_value['subtotal']);
        $cart_value['vat'] = ceil($cart_value['vat']);
        $cart_value['total_due'] = ceil($cart_value['subtotal'] + $cart_value['vat'] + $cart_value['discount']);
        return ['status' => 'success', 'data' => $cart_value, 'message' => 'ok!', 'code' => 200];
    }

    private function doCheckOut($cart_id, $customer_id, $payment_type, $payment_record, $coupon_id = 0): array
    {
        try {
            $cart = $this->getCart(intval($cart_id));
            $cart_value = $this->getCartSubtotal($cart_id);
            $coupon = ($coupon_id != 0) ? Coupon::where('coupon_code', $coupon_id)->first() : [];
            $orders = new Order();
            $orders->customer_id = $customer_id;
            $orders->carts = $cart;
            $orders->payment_type = $payment_type;
            $orders->payment_record = $payment_record;
            $orders->coupon = $coupon;
            $orders->value = $cart_value;
            $orders->cashier_id = auth()->user()->id;
            $orders->save();
            $this->clearCart($cart_id);
            event(new \App\Events\NewProductToCart($cart_id, 0));
            return ['status' => 'success', 'message' => 'Checkout successfully!', 'code' => 200];
        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
        }
    }

    private function listCoupons($cart_id = 0) {
        $coupons = Coupon::where('started_date', '<=', Carbon::now()->format('Y-m-d'))->where('expired_date', '>=', Carbon::now()->format('Y-m-d'))->get();
        $cart_value = $this->getCartSubtotal($cart_id)['data']['subtotal'];
        foreach ($coupons as $coupon_key => $coupon) {
            if(is_array($coupon->coupon_condition) && in_array('min_bill_value', $coupon->coupon_condition) && $cart_value < $coupon->coupon_minimum_condition) {
                $coupons->forget($coupon_key);
            }
        }
        return $coupons;
    }

    private function applyCouponToCart($coupon_id, $cart_id = 0): array
    {
        $status = $this->addProductToCart(0, $coupon_id, $cart_id, 3);
        if($status['code'] != 200) {
            return $status;
        }
        return ['status' => 'success', 'message' => 'Applied!', 'code' => 200];
    }

    private function updateCouponValue($cart_id = 0) {
        $carts = $this->getCart($cart_id);
        foreach($carts as $key => $cart) {
            if(array_key_exists(3, $cart)) {
                $coupon = Coupon::where('coupon_code', $cart[3]['name'])->first();
                $discount = $this->calculateDiscount($coupon, $cart_id);
                $carts[$key][3]['price'] = $discount['value'];
                $carts[$key][3]['type'] = $discount['type'];
            }
        }
        $this->putCart($cart_id, $carts);
    }

    private function calculateDiscount($coupon, $cart_id): array
    {
        if($coupon->coupon_type == 'amount') {
            $discount_value = $coupon->coupon_value * -1;
            $type = 'amount';
        } else {
            $cart_value = $this->getCartSubtotal($cart_id)['data']['total_due'];
            $discount_value = ceil($coupon->coupon_value / 100 * $cart_value * -1);
            $type = 'percent';
        }
        return ['value' => $discount_value, 'type' => $type];
    }

    // playground
    public function playground(Request $request)
    {

    }
}
