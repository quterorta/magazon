<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Specification;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('moderate', 1)->orderBy('created_at')->paginate(20);
        $pre_moderated_products = Product::where('moderate', 0)->paginate(20);
        return view('admin.product.index', compact('products', 'pre_moderated_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapters = Chapter::orderBy('title')->get();
        $specifications = Specification::orderBy('sub_category_id')->get();
        $shops = Shop::orderBy('title')->get();
        return view('admin.product.create', compact('chapters', 'shops', 'specifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->title = $request->title;
        $product->alias = $request->alias;
        $product->article = $request->article;
        $product->short_description = $request->short_description;
        $product->description = $request->description;

        $path_image_cover = $request->file('image_cover')->store('products');
        $product->image_cover = $path_image_cover;

        if (null !== $request->file('image_1')) {
            $path_image_1 = $request->file('image_1')->store('products');
            $product->image_1 = $path_image_1;
        }

        if (null !== $request->file('image_2')) {
            $path_image_2 = $request->file('image_2')->store('products');
            $product->image_2 = $path_image_2;
        }

        if (null !== $request->file('image_3')) {
            $path_image_3 = $request->file('image_3')->store('products');
            $product->image_3 = $path_image_3;
        }

        if (null !== $request->file('image_4')) {
            $path_image_4 = $request->file('image_4')->store('products');
            $product->image_4 = $path_image_4;
        }

        if (null !== $request->file('image_5')) {
            $path_image_5 = $request->file('image_5')->store('products');
            $product->image_5 = $path_image_5;
        }

        $product->price = $request->price;
        $product->product_in_sale = $request->product_in_sale;
        if (null !== $request->new_price) {
            $product->new_price = $request->new_price;
        }
        if (null !== $request->loan_terms) {
            $product->loan_terms = $request->loan_terms;
        }
        $product->user_id = 1;
        $product->shop_id = $request->shop_id;
        $product->active = $request->active;
        $product->moderate = $request->moderate;
        $product->recommended = $request->recommended;
        $product->popular = $request->popular;
    
        $product->save();

        foreach ($request->specification_id as $specification_id) {
            $product->specifications()->attach($specification_id);
        }

        return redirect()->back()->withSuccess('Товар успешно добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $chapters = Chapter::orderBy('title')->get();
        $categories = $product->category->chapter->categories;
        $subcategories = $product->category->sub_categories;
        $subcategory = SubCategory::find($product->sub_category_id);
        $specifications = $subcategory->specifications;
        $shops = Shop::orderBy('title')->get();
        return view('admin.product.edit', compact('chapters', 'shops', 'specifications', 'product', 'categories', 'subcategories', 'specifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->title = $request->title;
        $product->alias = $request->alias;
        $product->article = $request->article;
        $product->short_description = $request->short_description;
        $product->description = $request->description;

        if (null !== $request->file('image_cover')) {
            $path_image_cover = $request->file('image_cover')->store('products');
            $product->image_cover = $path_image_cover;
        }
        if (null !== $request->file('image_1')) {
            $path_image_1 = $request->file('image_1')->store('products');
            $product->image_1 = $path_image_1;
        }
        if (null !== $request->file('image_2')) {
            $path_image_2 = $request->file('image_2')->store('products');
            $product->image_2 = $path_image_2;
        }
        if (null !== $request->file('image_3')) {
            $path_image_3 = $request->file('image_3')->store('products');
            $product->image_3 = $path_image_3;
        }
        if (null !== $request->file('image_4')) {
            $path_image_4 = $request->file('image_4')->store('products');
            $product->image_4 = $path_image_4;
        }
        if (null !== $request->file('image_5')) {
            $path_image_5 = $request->file('image_5')->store('products');
            $product->image_5 = $path_image_5;
        }

        $product->price = $request->price;
        $product->product_in_sale = $request->product_in_sale;

        if (null !== $request->new_price) {
            $product->new_price = $request->new_price;
        }
        if (null !== $request->loan_terms) {
            $product->loan_terms = $request->loan_terms;
        }

        $product->user_id = 1;
        $product->shop_id = $request->shop_id;
        $product->active = $request->active;
        $product->moderate = $request->moderate;
        
        $product->recommended = $request->recommended;
        $product->popular = $request->popular;

        $product->specifications()->detach();
        foreach ($request->specification_id as $specification_id) {
            $product->specifications()->attach($specification_id);
        }

        $product->save();

        return redirect()->back()->withSuccess('Товар успешно изменен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->specifications()->detach();
        $product->delete();
        return redirect()->back()->withSuccess('Товар удален!');
    }
    
    public function moderate($product_id)
    {
        $product = Product::find($product_id);
        $product->moderate = 1;
        $product->save();
        return redirect()->back()->withSuccess('Товар успешно изменен!');
    }
    
    public function nonmoderate($product_id)
    {
        $product = Product::find($product_id);
        $product->moderate = 0;
        $product->save();
        return redirect()->back()->withSuccess('Товар успешно изменен!');
    }

    public function premoderate()
    {
        $pre_moderated_products = Product::where('moderate', 0)->paginate(20);
        return view('admin.product.pre_moderated_products', compact('pre_moderated_products'));
    }
    
    public function productReviews($product_id) {
        $product = Product::find($product_id);
        $reviews = $product->rewiews()->paginate(20);
        return view('admin.product.product_reviews', compact('product', 'reviews'));
    }

}
