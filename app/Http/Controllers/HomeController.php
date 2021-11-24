<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Chapter;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use App\Models\Order;
use App\Models\Specification;
use App\Models\UserShipment;
use App\Models\Shop;
use App\Models\ShopReview;
use App\Models\Rewiew;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index() {

        $user = Auth::user();

        $sales_products = Product::where('moderate', 1)->where('active', 1)->where('product_in_sale', 1)->take(4)->get();
        $chapters_for_menu = Chapter::orderBy('title')->get();
        $popular_products = Product::where('moderate', 1)->where('active', 1)->orderBy('view_count', 'desc')->take(4)->get();
        $recommend_products = Product::where('moderate', 1)->where('active', 1)->where('recommended', 1)->orderBy('view_count', 'desc')->take(4)->get();

        if(isset($user)) {
            $recently_products = $user->viewed_products->unique()->sortBy('created_at')->take(4);
        } else {
            $recently_products = null;
        }

        return view('home', compact('sales_products', 'popular_products', 'recommend_products', 'chapters_for_menu', 'recently_products'));

    }

    public function showProduct($category_alias, $product_alias) {

        $all_categories = Category::all();
        $all_products = Product::all();

        $current_product = Product::where('alias', $product_alias)->first();

        return view('products.product-detail', [
            'current_product' => $current_product,
        ]);
    }

    public function showRole() {
        $current_user = auth()->user();
        dd($current_user);
    }

    public function cabinet() {

        $user = Auth::user();
        $countries = Country::orderBy('title')->get();
        $regions = Region::orderBy('title')->get();
        $cities = City::orderBy('title')->get();
        if ($user) {
            $shipment = Auth::user()->shipment;
        }

        if (isset($shipment)) {
            $user_country = Country::where('id', '=', Auth::user()->shipment->country_id)->first();
            $user_region = Region::where('id', '=', Auth::user()->shipment->region_id)->first();
            $user_city = City::where('id', '=', Auth::user()->shipment->city_id)->first();

            return view('auth.cabinet', compact('user', 'countries', 'regions', 'cities', 'user_country', 'user_region', 'user_city'));
        } else {
            return view('auth.cabinet', compact('user', 'countries', 'regions', 'cities'));
        }
    }

    public function filterCategoryForSubcategoryCreate(Request $request) {
        $chapter_id = $request->chapter_sort_id;
        $chapter = Chapter::where('id', '=', $chapter_id)->first();
        $sorted_categories = $chapter->categories;
        return response()->json($sorted_categories);
    }

    public function filterCountryForCityCreate(Request $request) {
        $country_id = $request->country_sort_id;
        $country = Country::where('id', '=', $country_id)->first();
        $sorted_region = $country->regions;
        return response()->json($sorted_region);
    }

    public function filterRegionForCityCreate(Request $request) {
        $region_id = $request->region_sort_id;
        $region = Region::where('id', '=', $region_id)->first();
        $sorted_cities = $region->cities;
        return response()->json($sorted_cities);
    }

    public function shipmentCreate(Request $request){

        $shipment = new UserShipment();
        $shipment->country_id = $request->country_ship;
        $shipment->region_id = $request->region_ship;
        $shipment->city_id = $request->city_ship;
        $shipment->full_adress = $request->full_adress;
        $shipment->user_id = Auth::user()->id;
        $shipment->save();

        return redirect()->back()->withSuccess('Адрес доставки успешно добавлен!');
    }

    public function shipmentUpdate(Request $request){

        $shipment = Auth::user()->shipment;
        $shipment->country_id = $request->country_ship;
        $shipment->region_id = $request->region_ship;
        $shipment->city_id = $request->city_ship;
        $shipment->full_adress = $request->full_adress;
        $shipment->user_id = Auth::user()->id;
        $shipment->save();

        return redirect()->back()->withSuccess('Адрес доставки успешно изменен!');
    }

    public function userInfoUpdate(Request $request) {

        $user = Auth::user();
        $user->last_name = $request->last_name;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->save();

        return redirect()->back()->withSuccess('Ваши личные данные обновлены!');
    }

    public function selectCategoryForProduct(Request $request) {
        $chapter_id = $request->chapter_sort_id;
        $chapter = Chapter::where('id', '=', $chapter_id)->first();
        $sorted_categories = $chapter->categories;
        return response()->json($sorted_categories);
    }

    public function selectSubCategoryForProduct(Request $request) {
        $category_id = $request->category_sort_id;
        $category = Category::where('id', '=', $category_id)->first();
        $sorted_subcategories = $category->sub_categories;
        return response()->json($sorted_subcategories);
    }

    public function selectSpecificationsForProduct(Request $request) {
        $subcategory_id = $request->subcategory_sort_id;
        $subcategory = SubCategory::where('id', '=', $subcategory_id)->first();
        $sorted_specifications = $subcategory->specifications;
        return response()->json($sorted_specifications);
    }

    public function addSpecificationByModalWindow(Request $request) {

        $specification = new Specification();
        $specification->sub_category_id = $request->subcategory_id_for_spec;
        $specification->name = $request->name_for_spec;
        $specification->value = $request->value_for_spec;
        $specification->dimension = $request->dimension_for_spec;
        $specification->in_filter = $request->in_filter_for_spec;
        $specification->save();

        return response()->json($specification);
    }

    public function productDetail($category_alias, $sub_category_alias, $product_id) {
        $product = Product::find($product_id);
        if ($product->view_count == null) {
            $product->view_count = 1;
            $product->save();
        }
        $product->increment('view_count');
        if (auth()->check()) {
            $product->user_views()->attach(auth()->user()->id);
        }
        $products_reviews = $product->rewiews()->paginate(10);

        $shop = $product->shop;
        $orders = Order::whereHas('products', function(Builder $query) use($shop) {
            $query->where('shop_id', $shop->id);
        })->get();
        $products_counter = count($orders);

        $reviews = $product->rewiews()->paginate(10);

        $similar_products = Product::where('sub_category_id', $product->sub_category->id)->inRandomOrder()->get()->take(4);

        return view('products.product-detail', compact('product', 'products_reviews', 'products_counter', 'reviews', 'similar_products'));
    }

    public function storeProductReview($product_id, Request $request) {
        $product = Product::find($product_id);

        $review = new Rewiew();
        $review->user_id = auth()->user()->id;
        $review->product_id = $product->id;
        $review->rating = $request->rating;
        $review->rewiew = $request->review;
        $review->save();

        return redirect()->back()->withSuccess('Recenzia dvs. a fost adăugată la produs!');
    }

    public function catalog() {

        //Получаем недавно просмотренные товары
        $user = Auth::user();
        if(isset($user)) {
            $recently_products = $user->viewed_products->unique()->sortBy('created_at')->take(4);
        } else {
            $recently_products = null;
        }

        //Получаем все разделы
        $chapters = Chapter::orderBy('title')->get();

        return view('catalog.index', compact('recently_products', 'chapters'));
    }

    public function allSalesProducts() {}

    public function allPopularProducts() {}

    public function allRecommendedProducts() {}

    public function viewHistory() {}

    public function showChapter($chapter_alias) {
        $chapter = Chapter::where('alias', $chapter_alias)->first();
        return view('catalog.chapter', compact('chapter'));
    }

    public function showCategory($chapter_alias, $category_alias, Request $request) {

        $category = Category::where('alias', $category_alias)->first();

        $pre_filter_products = $category->products()->where('moderate', 1);

        if (null !== $request->input('sort') and $request->input('sort') == 'Mai ieftin') {
            // <!-- Дешевле -->
            $products = $pre_filter_products->orderBy('price');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Mai scump') {
            // <!-- Дороже -->
            $products = $pre_filter_products->orderBy('price', 'desc');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Mai popular mai întâi') {
            // <!-- Популярные -->
            $products = $pre_filter_products->orderBy('view_count', 'desc');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Mai puțin popular mai întâi') {
            // <!-- Непопулярные -->
            $products = $pre_filter_products->orderBy('view_count');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Alfabetic (A-Z)') {
            // <!-- А-Я -->
            $products = $pre_filter_products->orderBy('title');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Alfabetic (Z-A)') {
            // <!-- Я-А -->
            $products = $pre_filter_products->orderBy('title', 'desc');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Produse cu reducere mai întâi') {
            // <!-- Скидочные товары -->
            $products = $pre_filter_products->orderBy('product_in_sale', 'desc');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Produsele recomandate mai întâi') {
            // <!-- Рекомендуемые -->
            $products = $pre_filter_products->orderBy('recommended', 'desc');
        } else if (null == $request->input()) {
            $products = $pre_filter_products->orderBy('updated_at', 'desc');
        }

        $products = $products->paginate(20);

        return view('catalog.category', compact('category', 'products'));
    }

    public function showSubCategory($chapter_alias, $category_alias, $sub_category_alias, Request $request) {

        $sub_category = SubCategory::where('alias', $sub_category_alias)->first();

        $specifications = $sub_category->specifications->where('in_filter', 1);

        $pre_filter_products = $sub_category->products()->where('moderate', 1);

        $specifications_for_filter = array();

        if (null !== $request->input('sort') and $request->input('sort') == 'Mai ieftin') {
            // <!-- Дешевле -->
            $products = $pre_filter_products->orderBy('price');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Mai scump') {
            // <!-- Дороже -->
            $products = $pre_filter_products->orderBy('price', 'desc');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Mai popular mai întâi') {
            // <!-- Популярные -->
            $products = $pre_filter_products->orderBy('view_count', 'desc');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Mai puțin popular mai întâi') {
            // <!-- Непопулярные -->
            $products = $pre_filter_products->orderBy('view_count');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Alfabetic (A-Z)') {
            // <!-- А-Я -->
            $products = $pre_filter_products->orderBy('title');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Alfabetic (Z-A)') {
            // <!-- Я-А -->
            $products = $pre_filter_products->orderBy('title', 'desc');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Produse cu reducere mai întâi') {
            // <!-- Скидочные товары -->
            $products = $pre_filter_products->orderBy('product_in_sale', 'desc');
        } else if(null !== $request->input('sort') and $request->input('sort') == 'Produsele recomandate mai întâi') {
            // <!-- Рекомендуемые -->
            $products = $pre_filter_products->orderBy('recommended', 'desc');
        } else if (null == $request->input()) {
            $products = $pre_filter_products->orderBy('updated_at', 'desc');
        }

        if (null !== $request->input('min_price') and null !== $request->input('max_price')) {
            if (isset($products)) {
                $products = $products->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
            } else {
                $products = $pre_filter_products->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
            }

            foreach (array_keys($request->input()) as $key_request_input) {
                if ($key_request_input !== 'sort' and $key_request_input !== 'min_price' and $key_request_input !== 'max_price') {
                    if (is_iterable($request->input($key_request_input))) {
                        $specifications_for_filter[str_replace('_', ' ', $key_request_input)] = $request->input($key_request_input);
                    }
                }
            }

        }

        foreach(array_keys($specifications_for_filter) as $product_spec) {
            $products = $products->whereHas('specifications', function(Builder $query) use($specifications_for_filter, $product_spec){
                $query->whereIn('specifications.id', array_values($specifications_for_filter[$product_spec]));
            });
        }

        $products = $products->paginate(20);

        return view('catalog.sub_category', compact('sub_category', 'products', 'specifications', 'specifications_for_filter'));
    }

    public function addFavoriteProduct(Request $request) {

        $product = Product::find($request->product_id);
        $user = User::find($request->user_id);

        if (isset($product) and isset($user)) {

            if ($product->user_favorites()->where('users.id', $user->id)->exists()) {} else {
                $product->user_favorites()->attach($user->id);
            }
            return response()->json($product);
        } else {
            $error = 'Товар или пользователь не найден!';
            return response()->json($error);
        }
    }

    public function removeFavoriteProduct(Request $request) {

        $product = Product::find($request->product_id);
        $user = User::find($request->user_id);

        if (isset($product) and isset($user)) {

            if ($product->user_favorites()->where('users.id', $user->id)->exists()) {
                $product->user_favorites()->detach($user->id);
            } else {
            }
            return response()->json($product);
        } else {
            $error = 'Товар или пользователь не найден!';
            return response()->json($error);
        }
    }

    public function viewAllShops(Request $request) {

        if ($request->input()) {

            if ($request->input('sort') == 'Mai popular mai întâi') {
                $shops = Shop::orderBy('view_count', 'desc')->paginate(12);
            }
            else if ($request->input('sort') == 'Mai puțin popular mai întâi') {
                $shops = Shop::orderBy('view_count')->paginate(12);
            }
            else if ($request->input('sort') == 'Alfabetic (A-Z)') {
                $shops = Shop::orderBy('title')->paginate(12);
            }
            else if ($request->input('sort') == 'Alfabetic (Z-A)') {
                $shops = Shop::orderBy('title', 'desc')->paginate(12);
            }
            else if ($request->input('sort') == 'Vânzătorii oficiali mai întâi') {
                $shops = Shop::orderBy('official_saller', 'desc')->paginate(12);
            } else if ($request->input('sort') == 'Prin evaluare (descrescătoare)') {
                $shops = Shop::orderBy('rating', 'desc')->paginate(12);
            } else if ($request->input('sort') == 'Prin evaluare (crescătoare)') {
                $shops = Shop::orderBy('rating')->paginate(12);
            }
        } else {
            $shops = Shop::orderBy('created_at', 'desc')->paginate(12);
        }

        return view('shops.all-shops', compact('shops'));
    }

    public function detailViewShop($shop_alias, Request $request) {
        $shop = Shop::where('slug', $shop_alias)->first();
        $shop->increment('view_count');

        if (null !== $request->input()) {

            if(null !== $request->input('min_price') and null !== $request->input('max_price')) {
                $products = $shop->products()->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
            } else {
                $products = $shop->products();
            }

            if (null !== $request->input('category')) {
                $products = $products->whereIn('category_id', $request->input('category'));
            }

            if (null !== $request->input('sub_category')) {
                $products = $products->whereIn('sub_category_id', $request->input('sub_category'));
            }

            if (null !== $request->input('sort')) {
                if ($request->input('sort') == 'Mai ieftin') {
                    // Дешевле
                    $products = $products->orderBy('price');
                } else if ($request->input('sort') == 'Mai scump') {
                    // Дороже
                    $products = $products->orderBy('price', 'desc');
                } else if ($request->input('sort') == 'Mai popular mai întâi') {
                    // Популярные
                    $products = $products->orderBy('view_count', 'desc');
                } else if ($request->input('sort') == 'Mai puțin popular mai întâi') {
                    // Непопулярные
                    $products = $products->orderBy('view_count');
                } else if ($request->input('sort') == 'Alfabetic (A-Z)') {
                    // А-Я
                    $products = $products->orderBy('title');
                } else if ($request->input('sort') == 'Alfabetic (Z-A)') {
                    // Я-А
                    $products = $products->orderBy('title', 'desc');
                } else if ($request->input('sort') == 'Produse cu reducere mai întâi') {
                    // Скидочные товары
                    $products = $products->orderBy('product_in_sale', 'desc');
                } else if ($request->input('sort') == 'Produsele recomandate mai întâi') {
                    // Рекомендуемые
                    $products = $products->orderBy('recommended', 'desc');
                }
            }
            $products = $products->paginate(12);
        } else {
            $products = $shop->products()->paginate(12);
        }

        $orders = Order::whereHas('products', function(Builder $query) use($shop) {
            $query->where('shop_id', $shop->id);
        })->get();
        $products_counter = count($orders);

        $chapters_list = [];
        $categories_list = [];
        $sub_categories_list = [];

        foreach ($shop->products as $product) {
            $sub_category = $product->sub_category;
            $category = $product->category;
            $chapter = $category->chapter;
            if (!in_array($sub_category, $sub_categories_list)) {
                $sub_categories_list[] = $sub_category;
            }
            if (!in_array($category, $categories_list)) {
                $categories_list[] = $category;
            }
            if (!in_array($chapter, $chapters_list)) {
                $chapters_list[] = $chapter;
            }
        }

        $reviews = $shop->reviews()->paginate(10);

        return view('shops.shop-page', compact('shop', 'products_counter', 'products', 'orders', 'sub_categories_list', 'categories_list', 'chapters_list', 'reviews'));
    }

    public function storeShopReview($shop_id, Request $request) {

        $shop = Shop::find($shop_id);
        $user = Auth::user();

        $review = new ShopReview();

        $review->user_id = $user->id;
        $review->shop_id = $shop->id;
        $review->rating = $request->rating;
        $review->review = $request->review;

        $review->save();

        $shop_rating = $shop->reviews()->avg('rating');
        $shop->rating = $shop_rating;
        $shop->save();

        return redirect()->back()->withSuccess('Recenzia dvs. a fost adăugată cu succes!');
    }
    
    public function userFavoriteProducts($user_id) {
        
        $user = User::find($user_id);
        $products = $user->favorite_products()->paginate(9);
        
        return view('user.favorite', compact('products'));
        
    }

}
