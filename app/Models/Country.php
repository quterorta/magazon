<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function regions(){
        return $this->hasMany(Region::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
