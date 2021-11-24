<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rewiew;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class RewiewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rewiews = Rewiew::orderBy('product_id')->paginate(20);
        return view('admin.rewiew.index', compact('rewiews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('id')->get();
        $products = Product::orderBy('id')->get();

        return view('admin.rewiew.create', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rewiew = new Rewiew();
        $rewiew->user_id = $request->user_id;
        $rewiew->product_id = $request->product_id;
        $rewiew->rating = $request->rating;
        $rewiew->rewiew = $request->rewiew;
        $rewiew->save();

        return redirect()->back()->withSuccess('Отзыв к продукту успешно "'.$rewiew->product->title.'" добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rewiew  $rewiew
     * @return \Illuminate\Http\Response
     */
    public function show(Rewiew $rewiew)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rewiew  $rewiew
     * @return \Illuminate\Http\Response
     */
    public function edit(Rewiew $rewiew)
    {
        $users = User::orderBy('id')->get();
        $products = Product::orderBy('id')->get();

        return view('admin.rewiew.edit', compact('users', 'products', 'rewiew'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rewiew  $rewiew
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rewiew $rewiew)
    {
        $rewiew->user_id = $request->user_id;
        $rewiew->product_id = $request->product_id;

        if (null !== $request->rating) {
            $rewiew->rating = $request->rating;
        }

        $rewiew->rewiew = $request->rewiew;
        $rewiew->save();

        return redirect()->back()->withSuccess('Отзыв к продукту успешно "'.$rewiew->product->title.'" изменен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rewiew  $rewiew
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rewiew $rewiew)
    {
        $rewiew->delete();
        return redirect()->back()->withSuccess('Отзыв удален!');
    }
}
