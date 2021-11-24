<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Chapter;
use App\Models\Specification;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\ShopConfirmApplication;
use Illuminate\Database\Eloquent\Builder;

class SellerController extends Controller
{
    public function sellerBase() {
        $user = Auth::user();
        $shops = $user->shops;
        return view('seller.index', compact('user', 'shops'));
    }

    public function createShop() {
        return view('seller.shop.create');
    }

    public function storeShop(Request $request) {

        //Проверка на повтор названия
        if (Shop::where('title', '=', $request->title)->get()->isEmpty() == true) {
            if (Shop::where('slug', '=', $request->slug)->get()->isEmpty() == true) {

                $shop = new Shop();
                $shop->title = $request->title;
                $shop->slug = $request->slug;
                $shop->title = $request->title;

                $path = $request->file('banner_image')->store('shops');
                $shop->banner_image = $path;

                $shop->official_saller = 0;
                $shop->user_id = Auth::user()->id;

                $shop->save();

                return redirect()->route('create-shop-product', $shop->id)->withSuccess('Поздравляем, Ваш магазин создан. Теперь добавьте товары!');
            } else {
                return redirect()->back()->withErrors(['Магазин с таким slug уже существует!']);
            }
        } else {
            return redirect()->back()->withErrors(['Магазин с таким названием уже существует!']);
        }
    }

    public function editShop($shop_id) {
        $shop = Shop::find($shop_id);
        return view('seller.shop.edit', compact('shop'));
    }

    public function updateShop($shop_id, Request $request) {

        $shop = Shop::find($shop_id);

        $shop->title = $request->title;
        $shop->slug = $request->slug;

        if (null !== $request->banner_image) {
            Storage::delete($shop->banner_image);
            $path = $request->file('banner_image')->store('shops');
            $shop->banner_image = $path;
        }

        $shop->save();

        return redirect()->route('seller')->withSuccess('Изменения сохранены');
    }

    public function confirmShop($shop_id, Request $request) {

        $shop = Shop::find($shop_id);
        return view('seller.shop.confirm', compact('shop'));
    }

    public function createShopConfirmApplication($shop_id, Request $request) {

        $application = new ShopConfirmApplication();

        $application->text = $request->text_1;
        $application->text_1 = $request->text_2;
        $application->text_2 = $request->text_3;

        $application->shop_id = $shop_id;

        $application->save();
        return redirect()->route('seller')->withSuccess('Заявка подана!');
    }

    public function statisticShop($shop_id) {
        $shop = Shop::find($shop_id);

        $orders = Order::whereHas('products', function(Builder $query) use($shop) {
            $query->where('shop_id', $shop->id);
        })->get();

        $products_in_shop = $shop->products;

        $product_counter = count($orders);

        $product_rewiew = 0;
        foreach($shop->products as $product) {
            $product_rewiew = $product_rewiew + $product->rewiews->count();
        }
        $all_rewiews = $product_rewiew + $shop->reviews->count();

        $all_views = $products_in_shop->sum('view_count') + $shop->view_count;


        return view('seller.shop.index', compact('shop', 'product_counter', 'all_rewiews', 'all_views'));
    }

    public function allShopProducts($shop_id, Request $request) {

        $shop = Shop::find($shop_id);

        $pre_filter_products = $shop->products();

        if ($request->input()) {
            foreach (array_keys($request->input()) as $key_request_input) {
                if (is_iterable($request->input($key_request_input))) {
                    if (isset($products)) {
                        $products = $products->whereIn($key_request_input, $request->input($key_request_input));
                    } else {
                        $products = $pre_filter_products->whereIn($key_request_input, $request->input($key_request_input));
                    }
                } else {
                    if (isset($products)) {
                        $products = $products->where($key_request_input, $request->input($key_request_input));
                    } else {
                        $products = $pre_filter_products->where($key_request_input, $request->input($key_request_input));
                    }
                }
            }
            $products = $products->orderBy('updated_at', 'desc')->paginate(20);

        } else {
            $products = $shop->products()->orderBy('updated_at', 'desc')->paginate(20);
        }

        $filter_chapters = [];
        foreach ($shop->products->unique('category_id') as $product) {
            $chapter = $product->category->chapter;
            $filter_chapters[] = $chapter;
        }

        $filter_categories = [];
        foreach ($shop->products->unique('category_id') as $product) {
            $category = $product->category;
            $filter_categories[] = $category;
        }

        $filter_sub_categories = [];
        foreach ($shop->products->unique('sub_category_id') as $product) {
            $sub_category = $product->sub_category;
            $filter_sub_categories[] = $sub_category;
        }

        return view('seller.shop.all_products', compact('shop', 'products' ,'filter_chapters', 'filter_categories', 'filter_sub_categories'));
    }

    public function createShopProduct($shop_id) {
        $shop = Shop::find($shop_id);
        $chapters = Chapter::orderBy('title')->get();
        $specifications = Specification::all();
        return view('seller.product.create', compact('shop', 'chapters', 'specifications'));
    }

    public function storeShopProduct($shop_id, Request $request) {

        $shop = Shop::find($shop_id);

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

        $product->active = $request->active;
        $product->user_id = $shop->user->id;
        $product->shop_id = $shop_id;
        $product->moderate = 0;

        $product->save();

        foreach ($request->specification_id as $specification_id) {
            $product->specifications()->attach($specification_id);
        }

        return redirect()->route('all-shop-products', $shop_id)->withSuccess('Товар успешно добавлен!');
    }

    public function editShopProduct($shop_id, $product_id) {
        $shop = Shop::find($shop_id);
        $product = Product::find($product_id);
        $chapters = Chapter::orderBy('title')->get();
        $categories = $product->category->chapter->categories;
        $subcategories = $product->category->sub_categories;
        $subcategory = SubCategory::find($product->sub_category_id);
        $specifications = $subcategory->specifications;
        return view('seller.product.edit', compact('shop', 'product', 'chapters', 'categories', 'subcategories', 'subcategory', 'specifications'));
    }

    public function updateShopProduct($shop_id, $product_id, Request $request) {

        $shop = Shop::find($shop_id);
        $product = Product::find($product_id);
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

        $product->active = $request->active;

        $product->specifications()->detach();
        foreach ($request->specification_id as $specification_id) {
            $product->specifications()->attach($specification_id);
        }

        $product->save();

        return redirect()->route('all-shop-products', $shop_id)->withSuccess('Товар успешно изменен!');
    }

    public function activateShopProduct($shop_id, $product_id, Request $request) {

        $shop = Shop::find($shop_id);
        $product = Product::find($product_id);

        $product->active = 1;
        $product->save();

        return redirect()->back()->withSuccess('Товар добавлен в асортимент!');
    }

    public function deactivateShopProduct($shop_id, $product_id, Request $request) {

        $shop = Shop::find($shop_id);
        $product = Product::find($product_id);

        $product->active = 0;
        $product->save();

        return redirect()->back()->withSuccess('Товар убран изналичия!');
    }

    public function deleteShopProduct($shop_id, $product_id, Request $reques) {

        $shop = Shop::find($shop_id);
        $product = Product::find($product_id);

        $product->specifications()->detach();
        $product->delete();
        return redirect()->route('all-shop-products', $shop_id)->withSuccess('Товар удален!');
    }

    public function reviewShopProduct($shop_id, $product_id) {

        $shop = Shop::find($shop_id);
        $product = Product::find($product_id);
        $reviews = $product->rewiews()->orderBy('created_at', 'desc')->paginate(20);
        $all_reviews_count = $product->rewiews->count();
        $all_reviews_rating =  round($product->rewiews->avg('rating'), 2);

        return view('seller.product.reviews', compact('shop', 'product', 'reviews' ,'all_reviews_count' ,'all_reviews_rating'));
    }

    public function sortAllShopProducts($shop_id, $sort_by, Request $request) {
        $shop = Shop::find($shop_id);

        $pre_filter_products = $shop->products();

        if ($request->input()) {
            foreach (array_keys($request->input()) as $key_request_input) {
                if (is_iterable($request->input($key_request_input))) {
                    if (isset($products)) {
                        $products = $products->whereIn($key_request_input, $request->input($key_request_input));
                    } else {
                        $products = $pre_filter_products->whereIn($key_request_input, $request->input($key_request_input));
                    }
                } else {
                    if (isset($products)) {
                        $products = $products->where($key_request_input, $request->input($key_request_input));
                    } else {
                        $products = $pre_filter_products->where($key_request_input, $request->input($key_request_input));
                    }
                }
            }
            $products = $products;
        } else {
            $products = $shop->products();
        }

        if ($sort_by == "by-new") {
            $products = $products->orderBy('updated_at', 'desc')->paginate(20);
            $sort_type = "Сначала более новые";
        } else if ($sort_by == "by-old") {
            $products = $products->orderBy('updated_at')->paginate(20);
            $sort_type = "Сначала более старые";
        } else if ($sort_by == "by-az") {
            $products = $products->orderBy('title')->paginate(20);
            $sort_type = "По алфавиту (А-Я)";
        } else if ($sort_by == "by-za") {
            $products = $products->orderBy('title', 'desc')->paginate(20);
            $sort_type = "По алфавиту (Я-А)";
        } else if ($sort_by == "by-popular") {
            $products = $products->orderBy('view_count', 'desc')->paginate(20);
            $sort_type = "Сначала более популярные";
        } else if ($sort_by == "by-notpopular") {
            $products = $products->orderBy('view_count')->paginate(20);
            $sort_type = "Сначала менее популярные";
        }

        $filter_chapters = [];
        foreach ($products->unique('category_id') as $product) {
            $chapter = $product->category->chapter;
            $filter_chapters[] = $chapter;
        }

        $filter_categories = [];
        foreach ($products->unique('category_id') as $product) {
            $category = $product->category;
            $filter_categories[] = $category;
        }

        $filter_sub_categories = [];
        foreach ($products->unique('sub_category_id') as $product) {
            $sub_category = $product->sub_category;
            $filter_sub_categories[] = $sub_category;
        }

        return view('seller.shop.all_products', compact('shop', 'sort_by', 'sort_type', 'products', 'filter_chapters', 'filter_categories', 'filter_sub_categories', 'request'));
    }

    public function allShopOrders($shop_id) {

        $shop = Shop::find($shop_id);

        $products = $shop->products;
        $orders = Order::all();

        $shop_orders = [];

        foreach ($orders as $order) {
            foreach($order->products as $order_product) {
                foreach($products as $product) {
                    if($product->id == $order_product->id) {
                        if(in_array($order, $shop_orders)) {} else {
                            $shop_orders[] = $order;
                        }
                    }
                }
            }
        }

        return view('seller.shop.orders', compact('shop', 'orders', 'shop_orders'));
    }

    public function sortAllShopOrders($shop_id, $sort_by, Request $request) {

        $shop = Shop::find($shop_id);

        $products = $shop->products;

        $order_status = null;
        $sort_type = null;
        if ($sort_by == 'by-status-0') {
            $order_status = 0;
            $sort_type = 'Со статусом "Оформлен"';
        } else if ($sort_by == 'by-status-1') {
            $order_status = 1;
            $sort_type = 'Со статусом "Подтвержден"';
        } else if ($sort_by == 'by-status-2') {
            $order_status = 2;
            $sort_type = 'Со статусом "Выполнен"';
        } else if ($sort_by == 'by-status-3') {
            $order_status = 3;
            $sort_type = 'Со статусом "Отменен"';
        }

        $orders = Order::where('status', $order_status)->get();

        $shop_orders = [];

        foreach ($orders as $order) {
            foreach($order->products as $order_product) {
                foreach($products as $product) {
                    if($product->id == $order_product->id) {
                        if(in_array($order, $shop_orders)) {} else {
                            $shop_orders[] = $order;
                        }
                    }
                }
            }
        }

        return view('seller.shop.orders', compact('shop', 'orders', 'shop_orders', 'sort_type'));
    }

    public function allShopReviews($shop_id) {

        $shop = Shop::find($shop_id);
        $products = $shop->products;

        $all_reviews = [];
        $all_reviews['shop_reviews'] = $shop->reviews;

        $product_reviews = [];
        foreach ($products as $product) {
            $reviews = $product->rewiews;
            if ( $reviews->isNotEmpty() ) {
                $product_reviews[] = $reviews;
            }
        }
        $all_reviews['product_reviews'] = $product_reviews;

        $count_product_reviews = null;

        foreach ($products as $product) {
            foreach($product->rewiews as $review) {
                $count_product_reviews = $count_product_reviews + 1;
            }
        }


        return view('seller.shop.reviews', compact('shop', 'products', 'all_reviews', 'product_reviews', 'count_product_reviews'));
    }

    public function shopViewStatistic($shop_id) {

        $shop = Shop::find($shop_id);
        $products = $shop->products()->orderBy('view_count', 'desc')->paginate(20);

        return view('seller.shop.view_statistic', compact('shop', 'products'));
    }



}

