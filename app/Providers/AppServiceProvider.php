<?php

namespace App\Providers;

use App\Models\Chapter;
use App\Models\Category;
use App\Models\Product;
use App\Models\Confirm;
use App\Models\Shop;
use App\Models\Order;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (auth()->check()) {
            $recently_products = auth()->user()->viewed_products->unique()->sortBy('created_at')->take(4);
        } else {
            $recently_products = null;
        }

        $chapters_for_menu = Chapter::orderBy('id')->get();
        $products = Product::orderBy('id')->get();

        $new_product_admin_marker = Product::where('moderate', 0)->count();
        $new_confirm_admin_marker = Confirm::where('is_confirmed', 0)->count();
        $new_order_admin_marker = Order::where('status', 0)->count();

        View::share([
            'recently_products' => $recently_products,
            'chapters_for_menu' => $chapters_for_menu,
            'products' => $products,
            'new_product_admin_marker' => $new_product_admin_marker,
            'new_confirm_admin_marker' => $new_confirm_admin_marker,
            'new_order_admin_marker' => $new_order_admin_marker,
        ]);

    }
}
