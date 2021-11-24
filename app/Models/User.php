<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;

    public function shipment() {
        return $this->hasOne(UserShipment::class);
    }

    public function shops() {
        return $this->hasMany(Shop::class);
    }

    public function rewiews() {
        return $this->hasMany(Rewiew::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function viewed_products() {
        return $this->belongsToMany(Product::class, 'product_view');
    }

    public function favorite_products() {
        return $this->belongsToMany(Product::class, 'product_favorite_user');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
