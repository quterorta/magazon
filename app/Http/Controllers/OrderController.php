<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders;
        return $orders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $cart_id = $_COOKIE['cart_id'];
        \Cart::session($cart_id);
        $cart_items = \Cart::getContent();

        $countries = Country::orderBy('title')->get();

        if(auth()->check()) {
            $user = Auth::user();
            $shipment = $user->shipment;
            return view('order.create', compact('cart_items', 'user', 'shipment', 'countries'));
        }

        return view('order.create', compact('cart_items', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Получение пользователя
        $user = Auth::user();

        // Создание экземпляра заказа
        $order = new Order();
        $order->status = 0;
        $order->user_id = $user->id;
        $order->last_name = $request->last_name;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->country_id = $request->country_ship;
        $order->region_id = $request->region_ship;
        $order->city_id = $request->city_ship;
        $order->adress_shipment = $request->full_adress;
        $order->save();

        // Заполнение связей заказ-продукт
            //Получаем все товары из корзины
        $cart_id = $_COOKIE['cart_id'];
        \Cart::session($cart_id);
        $cart_items = \Cart::getContent();
            //Перебор товаров
        foreach ($cart_items as $product) {
                //Проверка количества товаров
            if($product->quantity > 1) {
                for($i=0; $i<$product->quantity; $i++) {
                    $order->products()->attach($product->id);
                }
            } else {
                $order->products()->attach($product->id);
            }
        }

        // Очистка корзины
        \Cart::session($cart_id)->clear();

        return view('order.success', compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
