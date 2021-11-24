<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use App\Models\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{

    public function cart() {

        if (!isset($_COOKIE['cart_id'])) setcookie('cart_id', uniqid());
        $cart_id = $_COOKIE['cart_id'];

        \Cart::session($cart_id);

        $cart_items = \Cart::getContent();

        return view('cart.cart', compact('cart_items'));
    }

    public function addToCart(Request $request) {

        $product = Product::where('id', $request->id)->first();

        if (!isset($_COOKIE['cart_id'])) setcookie('cart_id', uniqid());
        $cart_id = $_COOKIE['cart_id'];

        \Cart::session($cart_id);

        \Cart::add([
            'id' => (int) $product->id,
            'name' => $product->title,
            'price' => (int) $product->new_price ? $product->new_price : $product->price,
            'quantity' => (int) $request->qty,
            'attributes' => [
                'image_cover' => $product->image_cover,
                'image_1' => $product->image_1 ? $product->image_1 : null,
                'image_2' => $product->image_2 ? $product->image_2 : null,
                'image_3' => $product->image_3 ? $product->image_3 : null,
                'image_4' => $product->image_4 ? $product->image_4 : null,
                'image_5' => $product->image_5 ? $product->image_5 : null,
                'category' => $product->category,
                'sub_category' => $product->sub_category,
            ],
        ]);


        return response()->json(\Cart::getContent());
    }

    public function cartRemove(Request $request, $id) {

        if (!isset($_COOKIE['cart_id'])) setcookie('cart_id', uniqid());
        $cart_id = $_COOKIE['cart_id'];
        \Cart::session($cart_id)->remove($id);

        return redirect()->route('cart')->withSuccess('Articolul a fost scos din coș!');
    }

    public function cartClear(Request $request) {

        if (!isset($_COOKIE['cart_id'])) setcookie('cart_id', uniqid());
        $cart_id = $_COOKIE['cart_id'];
        \Cart::session($cart_id)->clear();

        return redirect()->route('cart')->withSuccess('Coșul a fost golit!');
    }

    public function minusProductInCart(Request $request) {

        if (!isset($_COOKIE['cart_id'])) setcookie('cart_id', uniqid());
        $cart_id = $_COOKIE['cart_id'];

        \Cart::session($cart_id)->update($request->id,[
            'quantity' => -1,
        ]);
        return response()->json(\Cart::getContent());
    }


}
