<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specification;
use App\Models\Chapter;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specifications = Specification::orderBy('sub_category_id')->paginate(20);
        return view('admin.specification.index', compact('specifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapters = Chapter::orderBy('title')->get();
        return view('admin.specification.create', compact('chapters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check_spec = Specification::where('sub_category_id', '=', $request->subcategory_id_for_spec)->where('name', '=', $request->name_for_spec)->where('value', '=', $request->value_for_spec)->get();

        if ( null !== $check_spec ) {
            return redirect()->back()->withErrors(['Характеристика уже существует!']);
        } else {
            $specification = new Specification();
            $specification->sub_category_id = $request->subcategory_id_for_spec;
            $specification->name = $request->name_for_spec;
            $specification->value = $request->value_for_spec;
            $specification->dimension = $request->dimension_for_spec;
            $specification->in_filter = $request->in_filter_for_spec;
            $specification->save();

            $specification_sub_category = $specification->sub_category->title;

            return redirect()->back()->withSuccess('Характеристика для подкатегории "'.$specification_sub_category.'" успешно добавлена!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function show(Specification $specification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function edit(Specification $specification)
    {
        $chapters = Chapter::orderBy('title')->get();
        return view('admin.specification.edit', compact('chapters', 'specification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specification $specification)
    {
        $specification->sub_category_id = $request->subcategory_id_for_spec;
        $specification->name = $request->name_for_spec;
        $specification->value = $request->value_for_spec;
        $specification->dimension = $request->dimension_for_spec;
        $specification->in_filter = $request->in_filter_for_spec;
        $specification->save();

        return redirect()->back()->withSuccess('Характеристика успешно изменена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specification $specification)
    {
        $specification->products()->detach();
        $specification->delete();
        return redirect()->back()->withSuccess('Характеристика удалена!');
    }
}
