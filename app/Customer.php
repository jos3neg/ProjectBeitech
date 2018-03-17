<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Product;
class Customer extends Model
{
    protected $fillable = [
        "name", "email",
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
