<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SpecificationController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\ShopRewiewController;
use App\Http\Controllers\Admin\RewiewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\ConfirmController;
use App\Http\Controllers\Admin\SeacrhProductController;

use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/* --------------------------------------------------- НУЖНО ДОБАВИТЬ СТРАНИЦЫ ---------------------------------------------------------- */
Route::get('/all-sales-products', [HomeController::class, 'allSalesProducts'])->name('all-sales-products');
Route::get('/all-popular-products', [HomeController::class, 'allPopularProducts'])->name('all-popular-products');
Route::get('/all-recommended-products', [HomeController::class, 'allRecommendedProducts'])->name('all-recommended-products');
Route::get('/view-history', [HomeController::class, 'viewHistory'])->name('view-history');
/* ------------------------------------------------------------------------------------------------------------------------------------- */

Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('/cart/cart-remove/{id}', [CartController::class, 'cartRemove'])->name('cart-remove');

Route::post('/add-favorite-product', [HomeController::class, 'addFavoriteProduct'])->name('add-favorite-product');
Route::post('/remove-favorite-product', [HomeController::class, 'removeFavoriteProduct'])->name('remove-favorite-product');

Route::post('/filter-category-for-subcategory-create', [HomeController::class, 'filterCategoryForSubcategoryCreate'])->name('filter-category-for-subcategory-create');
Route::post('/filter-country-for-city-create', [HomeController::class, 'filterCountryForCityCreate'])->name('filter-country-for-city-create');
Route::post('/filter-region-for-city-create', [HomeController::class, 'filterRegionForCityCreate'])->name('filter-region-for-city-create');
Route::post('/select-category-for-product', [HomeController::class, 'selectCategoryForProduct'])->name('select-category-for-product');
Route::post('/select-subcategory-for-product', [HomeController::class, 'selectSubCategoryForProduct'])->name('select-subcategory-for-product');
Route::post('/select-specifications-for-product', [HomeController::class, 'selectSpecificationsForProduct'])->name('select-specifications-for-product');
Route::post('/add-specification-by-modal-window', [HomeController::class, 'addSpecificationByModalWindow'])->name('add-specification-by-modal-window');


Route::post('/minus-product-in-cart', [CartController::class, 'minusProductInCart'])->name('minus-product-in-cart');
Route::get('/cart-clear', [CartController::class, 'cartClear'])->name('cart-clear');
Route::get('/cabinet', [HomeController::class, 'cabinet'])->name('cabinet');
Route::post('/shipment-create', [HomeController::class, 'shipmentCreate'])->name('shipment-create');
Route::post('/shipment-update', [HomeController::class, 'shipmentUpdate'])->name('shipment-update');
Route::post('/user-info-update', [HomeController::class, 'userInfoUpdate'])->name('user-info-update');

Route::get('/about', function() { return view('about'); })->name('about');

Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'adminBase'])->name('admin');
    Route::resource('user', UserController::class);
    Route::resource('chapter', ChapterController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubCategoryController::class);
    Route::resource('country', CountryController::class);
    Route::resource('region', RegionController::class);
    Route::resource('city', CityController::class);
    Route::get('product/moderate/{product_id}', [ProductController::class, 'moderate'])->name('product.moderate');
    Route::get('product/nonmoderate/{product_id}', [ProductController::class, 'nonmoderate'])->name('product.nonmoderate');
    Route::get('product/pre-moderate', [ProductController::class, 'premoderate'])->name('product.premoderate');
    Route::get('product/all-reviews/{product_id}', [ProductController::class, 'productReviews'])->name('product.reviews');
    Route::resource('product', ProductController::class);
    Route::resource('specification', SpecificationController::class);
    Route::resource('shop', ShopController::class);
    Route::resource('rewiew', RewiewController::class);
    Route::resource('shop-rewiew', ShopRewiewController::class);
    Route::resource('order', AdminOrderController::class);
    Route::resource('confirm', ConfirmController::class);
    Route::get('products/search', [SeacrhProductController::class, 'searchProducts'])->name('search-products');
});

Route::middleware(['role:seller'])->group(function () {
    Route::get('/seller', [SellerController::class, 'sellerBase'])->name('seller');
    Route::get('/shop/create', [SellerController::class, 'createShop'])->name('create-shop');
    Route::post('/shop/store', [SellerController::class, 'storeShop'])->name('store-shop');
    Route::get('/shop/{shop_id}/edit', [SellerController::class, 'editShop'])->name('edit-shop');
    Route::post('/shop/{shop_id}/create-confirm-application', [SellerController::class, 'createShopConfirmApplication'])->name('create-shop-confirm-application');

    Route::get('/shop/{shop_id}/all-products', [SellerController::class, 'allShopProducts'])->name('all-shop-products');
    Route::get('/shop/{shop_id}/all-products/sort-{sort_by}', [SellerController::class, 'sortAllShopProducts'])->name('sort-all-shop-products');

    Route::get('/shop/{shop_id}/all-orders', [SellerController::class, 'allShopOrders'])->name('all-shop-orders');
    Route::get('/shop/{shop_id}/all-orders/sort-{sort_by}', [SellerController::class, 'sortAllShopOrders'])->name('sort-all-shop-orders');

    Route::get('/shop/{shop_id}/create-product', [SellerController::class, 'createShopProduct'])->name('create-shop-product');
    Route::post('/shop/{shop_id}/store-product', [SellerController::class, 'storeShopProduct'])->name('store-shop-product');
    Route::get('/shop/{shop_id}/review-product/{product_id}', [SellerController::class, 'reviewShopProduct'])->name('review-shop-product');
    Route::get('/shop/{shop_id}/edit-product/{product_id}', [SellerController::class, 'editShopProduct'])->name('edit-shop-product');
    Route::put('/shop/{shop_id}/update-product/{product_id}', [SellerController::class, 'updateShopProduct'])->name('update-shop-product');
    Route::put('/shop/{shop_id}/activate-product/{product_id}', [SellerController::class, 'activateShopProduct'])->name('activate-shop-product');
    Route::put('/shop/{shop_id}/deactivate-product/{product_id}', [SellerController::class, 'deactivateShopProduct'])->name('deactivate-shop-product');
    Route::delete('/shop/{shop_id}/delete-product/{product_id}', [SellerController::class, 'deleteShopProduct'])->name('delete-shop-product');

    Route::get('/shop/{shop_id}/all-reviews', [SellerController::class, 'allShopReviews'])->name('all-shop-reviews');
    Route::get('/shop/{shop_id}/view-statistic', [SellerController::class, 'shopViewStatistic'])->name('shop-view-statistic');

    Route::get('/shop/{shop_id}/confirm', [SellerController::class, 'confirmShop'])->name('confirm-shop');
    Route::put('/shop/{shop_id}/update', [SellerController::class, 'updateShop'])->name('update-shop');

    Route::get('/shop/{shop_id}/statistic', [SellerController::class, 'statisticShop'])->name('statistic-shop');
    Route::post('/shop/{shop_id}/store-shop-review', [HomeController::class, 'storeShopReview'])->name('store-shop-review');
    Route::post('/product/{product_id}/store-product-review', [HomeController::class, 'storeProductReview'])->name('store-product-review');
});

Auth::routes();
Route::resource('order', OrderController::class);
Route::get('/catalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/catalog/chapter/{chapter_alias}', [HomeController::class, 'showChapter'])->name('show-chapter');

/* ------------------------------------------ МАГАЗИНЫ ----------------------------------------------- */
Route::get('/shops-catalog', [HomeController::class, 'viewAllShops'])->name('shops');
Route::get('/shops-catalog/{shop_alias}', [HomeController::class, 'detailViewShop'])->name('detail-shop');
/* ------------------------------------------ МАГАЗИНЫ ----------------------------------------------- */

/* ------------------------------------------ Пользователи ----------------------------------------------- */
Route::get('/user/{user_id}/favorite-products', [HomeController::class, 'userFavoriteProducts'])->name('favorite-products');
/* ------------------------------------------ Пользователи ----------------------------------------------- */

Route::get('/catalog/{chapter_alias}/{category_alias}', [HomeController::class, 'showCategory'])->name('show-category');
Route::get('/catalog/{chapter_alias}/{category_alias}/{sub_category_alias}', [HomeController::class, 'showSubCategory'])->name('show-sub_category');

Route::get('/{category_alias}/{product_alias}', [HomeController::class, 'showProduct'])->name('showProduct');
Route::get('/{category_alias}/{sub_category_alias}/{product_id}', [HomeController::class, 'productDetail'])->name('product-detail');
