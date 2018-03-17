<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
class Product extends Model
{
    protected $fillable = [
        "name", "price", "product_description",
    ];

    public function customers(){
        return $this->belongsToMany(Customer::class);
    }
}
