<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class SeacrhProductController extends Controller
{
    
    public function searchProducts(Request $request) {
        
        if($request->q!="") {
            $q = $request->q;
            $search_products = Product::where('id', $q)->
                                orWhere('article', $q)->
                                orWhere('title', 'like', '%'.$q.'%');
        }
        
        if ($request->q_moderate) {
            $q_moderate = $request->q_moderate;
            if(!isset($search_products)){
                $search_products = Product::orderBy('title');
            }
            if (count($q_moderate)>1) {
                $search_products->whereIn('moderate', $q_moderate);
            } else {
                $search_products->where('moderate', $q_moderate);
            }
        }
        if(!isset($search_products)) {
            $search_products = Product::orderBy('title');
        }
        $search_products = $search_products->paginate(20);
        
        return view('admin.product.search-and-filter', compact('search_products', 'request'));
    }
    
}
