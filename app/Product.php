<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
class Product extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "name", "price", "product_description",
    ];

    // name to lowercase before insert DB
    public function setNameAttribute($value){
        $this->attributes['name'] = strtolower($value);
    }

    // product_description to lowercase before insert DB
    public function setProductDescriptionAttribute($value){
        $this->attributes['product_description'] =strtolower($value);
    }

    // name in capital latters first character after consult DB
    public function getNameAttribute($value){
        return ucfirst($value);
    }
    // product in capital letters first character after select of database 
    public function getProductDescriptionAttribute($value){
        return ucfirst($value);
    }

    // relations between models
    public function customers(){
        return $this->belongsToMany(Customer::class);
    }
}
