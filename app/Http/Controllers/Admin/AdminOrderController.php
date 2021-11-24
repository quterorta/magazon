<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Country;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('status')->paginate(10);
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::where('id', '=', $request->order_id)->first();

        if ($request->removeProduct == true) {
            $product_id = $request->product_id;
            $order->products()->detach($product_id);
        } else if ($request->add_product_in_order_marker == true) {
            $order_product_id = $request->order_product_id;
            $order_product_qty = $request->order_product_qty;
            if ($order_product_qty > 1) {
                for ($i=0; $i < $order_product_qty; $i++) {
                    $order->products()->attach($order_product_id);
                }
            } else {
                $order->products()->attach($order_product_id);
            }
        } else {
            if (isset($request->product_id)) {
                $product_id = $request->product_id;
            }
            if (isset($request->product_qty)) {
                $product_qty = $request->product_qty;
            }

            if (isset($product_id)) {
                $order->products()->detach($product_id);

                if ($product_qty > 1) {
                    for ($i=0; $i < $product_qty; $i++) {
                        $order->products()->attach($product_id);
                    }
                } else {
                    $order->products()->attach($product_id);
                }
            }
        }

        return response()->json('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $countries = Country::orderBy('title')->get();
        return view('admin.order.edit', compact('order', 'countries'));
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
        $order->status = $request->status;
        $order->last_name = $request->last_name;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->country_id = $request->country_id;
        $order->region_id = $request->region_id;
        $order->city_id = $request->city_id;
        $order->adress_shipment = $request->adress_shipment;
        $order->save();

        return redirect()->back()->withSuccess('Заказ #'.$order->id.' успешно изменен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->products()->detach();
        $order->delete();
        return redirect()->back()->withSuccess('Заказ удален!');
    }

}
