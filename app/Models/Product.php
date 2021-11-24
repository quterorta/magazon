<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    	
    use HasFactory;
    
    protected $guarded = [];
    protected $fillable = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function sub_category(){
        return $this->belongsTo(SubCategory::class);
    }

    public function specifications() {
        return $this->belongsToMany(Specification::class, 'product_specification');
    }

    public function user_views() {
        return $this->belongsToMany(User::class, 'product_view');
    }

    public function user_favorites() {
        return $this->belongsToMany(User::class, 'product_favorite_user');
    }

    public function rewiews() {
        return $this->hasMany(Rewiew::class);
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_product');
    }

}
