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
        Log::info('New product added to cart: '.$product_id.' - '.$product_type . ' - ' . $cart_id . ' - ' . $screen_id);
        event(new \App\Events\NewProductToCart($cart_id, $screen_id));
        return ['status' => 'success', 'message' => 'Product added to cart successfully!', 'code' => 200];
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

    public function searchProduct(Request $request) {
        $name = $request->name;


        $product = Product::where('product_name','LIKE',"%$name%")->orwhere('barcode','LIKE',"%$name%")->get();


        return response()->json($product);
//        dd($product);


    }

    // playground
    public function playground(Request $request) {

    }
}
