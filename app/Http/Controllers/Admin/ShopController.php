<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::orderBy('title')->paginate(15);
        return view('admin.shop.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('admin.shop.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $shop = new Shop();
        $shop->title = $request->title;
        $shop->slug = $request->alias;

        $path = $request->file('banner-image')->store('shops');
        $shop->banner_image = $path;

        $shop->official_saller = $request->official_seller;
        $shop->user_id = $request->user_id;
        $shop->save();

        return redirect()->back()->withSuccess('Магазин успешно добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $products = Product::where('shop_id', '=', $shop->id)->paginate(15);
        return view('admin.shop.show-products-for-shop', compact('shop', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        $users = User::all();
        return view('admin.shop.edit', compact('users', 'shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        $shop->title = $request->title;
        $shop->slug = $request->alias;

        if (null !== $request->file('banner-image')) {
            $path = $request->file('banner-image')->store('shops');
            $shop->banner_image = $path;
        }

        $shop->official_saller = $request->official_seller;
        $shop->user_id = $request->user_id;
        $shop->save();

        return redirect()->back()->withSuccess('Магазин успешно изменен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();
        return redirect()->back()->withSuccess('Магазин удален!');
    }
}
