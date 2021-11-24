<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::orderBy('title')->paginate(10);

        return view('admin.subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $chapters = Chapter::orderBy('title')->get();
        if (null !== $request->chapter_sort_id) {
            $chapter_sort_id = $request->chapter_sort_id;
            $sorted_categories = $chapter_sort_id->categories;
            return response($sorted_categories);
        }
        return view('admin.subcategory.create', compact('chapters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subcategory = new SubCategory();
        $subcategory->category_id = $request->category_id;
        $subcategory->title = $request->title;

        $path = $request->file('image')->store('subcategories');
        $subcategory->image = $path;

        $subcategory->alias = $request->alias;
        $subcategory->save();

        return redirect()->back()->withSuccess('Подкатегория была успешно добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subcategory)
    {
        $chapters = Chapter::orderBy('title')->get();
        $categories = Category::orderBy('title')->get();
        return view('admin.subcategory.edit', compact('subcategory', 'chapters', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $subcategory->category_id = $request->category_id;
        $subcategory->title = $request->title;

        if (null !== $request->file('image')) {
            Storage::delete($subcategory->image);
            $path = $request->file('image')->store('categories');
            $subcategory->image = $path;
        }

        $subcategory->alias = $request->alias;
        $subcategory->save();

        return redirect()->back()->withSuccess('Подкатегория была успешно изменена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->back()->withSuccess('Подкатегория была успешно удалена!');
    }
}
