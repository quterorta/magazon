<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Confirm;
use Illuminate\Http\Request;

class ConfirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $confirms = Confirm::where('is_confirmed', '=', 0)->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.shop.confirm_index', compact('confirms'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Confirm  $confirm
     * @return \Illuminate\Http\Response
     */
    public function show(Confirm $confirm)
    {
        return view('admin.shop.confirm_show', compact('confirm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Confirm  $confirm
     * @return \Illuminate\Http\Response
     */
    public function edit(Confirm $confirm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Confirm  $confirm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Confirm $confirm)
    {
        if (null !== $request->cancel) {
            return redirect()->route('confirm.index')->withErrors(['Заявка отменена!']);
        }
        $confirm->is_confirmed = 1;
        $shop = $confirm->shop;
        $shop->official_saller = 1;
        $shop->save();
        $confirm->save();
        return redirect()->route('confirm.index')->withSuccess('Заявка подтверждена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Confirm  $confirm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Confirm $confirm)
    {
        $confirm->delete();
        return redirect()->back()->withSuccess('Заявка удалена!');
    }
}
