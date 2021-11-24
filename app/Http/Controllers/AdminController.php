<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Shop;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function adminBase(){

        $user = auth()->user();

        $products = Product::all();
        $moderated_products = Product::where('moderate', 1)->get();

        $orders = Order::all();
        $new_orders = Order::where('status', 0)->count();
        $confirmed_orders = Order::where('status', 1)->count();
        $completed_orders = Order::where('status', 2)->count();
        $canceled_orders = Order::where('status', 3)->count();

        $total_cost = 0;
        foreach ($orders as $order) {
            $order_sum = $order->products()->sum('price');
            $total_cost = $total_cost+$order_sum;
        }

        $users = User::all()->count();
        $shops = Shop::all()->count();

        return view('admin.admin-base', compact(
            'user',
            'products', 'moderated_products',
            'orders', 'new_orders', 'confirmed_orders', 'completed_orders', 'canceled_orders',
            'total_cost',
            'users', 'shops',
        ));
    }

    public function addProduct(Request $request) {

        $user = auth()->user();

        $product = new Product();

        $product->category_id = $request->input('category_id');
        $product->sub_category_id = $request->input('sub_category_id');
        $product->title = $request->input('title');
        $product->alias = $request->input('alias');
        $product->short_description = $request->input('short_description');
        $product->description = $request->input('description');

        $product->price = $request->input('price');
        $product->product_in_sale = $request->input('product_in_sale');
        $product_in_sale = $request->input('product_in_sale');
        if ($product_in_sale = 1) {
            $product->new_price = $request->input('new_price');
        }
        if (null !== $request->input('loan_terms')) {
            $product->loan_terms = $request->input('loan_terms');
        }
        if (null !== $request->input('specification_id')) {
            $product->specification_id = $request->input('specification_id');
        }

        $product->user_id = $user->id;
        if (null !== $user->shop) {
            $product->shop_id = $user->shop;
        }

        $product->save();
    }

}
