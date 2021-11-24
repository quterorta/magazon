<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirm extends Model
{
    use HasFactory;

    protected $table = 'shop_confirm_applications';

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
