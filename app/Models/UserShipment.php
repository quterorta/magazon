<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShipment extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasOne(User::class);
    }

    public function country() {
        return $this->hasOne(Country::class);
    }

    public function region() {
        return $this->hasOne(Region::class);
    }

    public function city() {
        return $this->hasOne(City::class);
    }

}
