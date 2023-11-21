<?php

namespace App\Http\Controllers;

use App\Events\NewProductToCart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $screen = $request->screen;
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

    // action functions
    private function addProductToCart($screen_id, $product_id, $cart_id, $product_type): array
    {
        try {
            $product = Product::find($product_id);
            $cart_id = intval($cart_id);
            $product_type = intval($product_type);
            $screen_id = intval($screen_id);
            if(!$product) {
                return ['status' => 'false', 'message' => 'Product not found!', 'code' => 404];
            }
            if($product_type != 0 && $product_type != 1) {
                return ['status' => 'false', 'message' => 'Invalid selling type!', 'code' => 400];
            }
            $cart = Cache::get('cart_'.$cart_id);
        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
        }
        try {
//            $available_quantity = intval($product->quantity) - intval($this->getProductHold($product_id));
//            if($available_quantity <= 0) {
//                return ['status' => 'false', 'message' => 'No more product available, please try to add some or remove from the other cart.', 'code' => 400];
//            }
            if(!$cart) {
                if($product_type == 0) {
                    $price = $product->price_box_discounted;
                } else {
                    $price = $product->price_item_discounted;
                }
                $cart[$product_id][$product_type] = [
                    "name" => $product->product_name,
                    "quantity" => 1,
                    "price" => $price,
                    "photo" => $product->product_image
                ];

            } else {
                if(isset($cart[$product_id][$product_type])) {
                    $cart[$product_id][$product_type]['quantity']++;
                } else {
                    if($product_type == 0) {
                        $price = $product->price_box_discounted;
                    } else {
                        $price = $product->price_item_discounted;
                    }
                    $cart[$product_id][$product_type] = [
                        "name" => $product->product_name,
                        "quantity" => 1,
                        "price" => $price,
                        "photo" => $product->product_image
                    ];
                }
            }
        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
        }

        Cache::put('cart_'.$cart_id, $cart);
        $cart_quantity = 0;
        if (array_key_exists(0, $cart[$product_id])) {
            $cart_quantity = $cart[$product_id][0]['quantity'];
        }
        if (array_key_exists(1, $cart[$product_id])) {
            $cart_quantity += $cart[$product_id][1]['quantity'];
        }
//        $this->placeProductHold($product_id, $cart_quantity);
        Log::info('New product added to cart: '.$product_id.' - '.$product_type . ' - ' . $cart_id . ' - ' . $screen_id);
        event(new \App\Events\NewProductToCart($cart_id, $screen_id));
        return ['status' => 'success', 'message' => 'Product added to cart successfully!', 'code' => 200];
    }

    private function removeFromCart($screen_id, $product_id, $cart_id, $product_type) {
        try {
            $cart = Cache::get('cart_'.$cart_id);
            if(!$cart) {
                return ['status' => 'false', 'message' => 'Cart not found!', 'code' => 404];
            }
            if($product_type != 0 && $product_type != 1) {
                return ['status' => 'false', 'message' => 'Invalid selling type!', 'code' => 400];
            }
            if(!isset($cart[$product_id][$product_type])) {
                return ['status' => 'false', 'message' => 'Product not found in cart!', 'code' => 404];
            }
            unset($cart[$product_id][$product_type]);
            if(count($cart[$product_id]) == 0) {
                unset($cart[$product_id]);
            }
            Cache::put('cart_'.$cart_id, $cart);
            event(new \App\Events\NewProductToCart($cart_id, $screen_id));
            // TODO: product hold
            return ['status' => 'success', 'message' => 'Product removed from cart successfully!', 'code' => 200];

        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage(), 'code' => 500];
        }

    }

    private function getCart($cart_id) {
        return Cache::get('cart_'.$cart_id);
    }

    private function clearCart($cart_id): array
    {
        Cache::forget('cart_'.$cart_id);
        return ['status' => 'success', 'message' => 'Cart cleared successfully!', 'code' => 200];
    }

    private function getScreen($screen_id) {
        return Cache::get('screen_'.$screen_id);
    }

    private function placeProductHold($product_id, $quantity) {
        $current_hold = $this->getProductHold($product_id);
        if($current_hold == 0) {
            $current_hold = $quantity;
        } else {
            $current_hold += $quantity;
        }
        Cache::put('hold_'.$product_id, $current_hold, 60*24*7);
    }

    private function getProductHold($product_id) {
        $hold = Cache::get('hold_'.$product_id);
        if(!$hold) {
            return 0;
        }
        return $hold;
    }

    // playground
    public function playground(Request $request) {

    }
}
