<?php

namespace App\Http\Controllers;

use App\Events\NewProductToCart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $screen = $request->screen;
        return view('cart.screen', compact('screen'));
    }

    public function addToCart(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $screen_id = $request->input('screen_id');
            $product_id = $request->input('product_id');
            $product = Product::find($product_id);
            $cart_id = intval($request->input('cart_id'));
            if(!$product) {
                return response(['status' => 'false', 'message' => 'Product not found!'], 500);
            }
            $product_type = intval($request->input('selling_type')); // 0 for box, 1 for piece
            if($product_type != 0 && $product_type != 1) {
                return response(['status' => 'false', 'message' => 'Invalid selling type!'], 500);
            }
            $cart = session()->get('cart_'.$cart_id);
        } catch (\Throwable $th) {
            return response(['status' => 'false', 'message' => $th->getMessage()], 500);
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
        } catch (\Throwable $th) {
            //throw $th;
        }

        session()->put('cart_'.$cart_id, $cart);
        event(new \App\Events\NewProductToCart($cart_id, $screen_id));
        return response()->json(['status' => 'success', 'message' => 'Product added to cart successfully!'], 200);

    }

    public function clearCart($cart_id): \Illuminate\Http\JsonResponse
    {
        session()->forget('cart_'.$cart_id);
        event(new \App\Events\NewProductToCart($cart_id, 1));
        return response()->json(['status' => 'success', 'message' => 'Cart cleared successfully!'], 200);
    }

    public function clearCartRoute(Request $request)
    {
        $this->clearCart($request->cart_id);
    }

    public function loadCart(){

    }
}
