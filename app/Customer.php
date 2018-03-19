<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Product;
class Customer extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        "name", "email",
    ];

    // Este metodo nos convierte el nombre a minuscula justo antes de 
    // registralo en DB
    public function setNameAttribute($value){
        $this->attributes['name'] = strtolower($value);
    }

    // Igual para el email
    public function setEmailAttribute($value){
        $this->attributes['email'] = strtolower($value);
    }
    // Este metodo no coloca la primera letra en mayuscula del nombre, justo despues de ser
    // consultado. Asi por ej: en la BD esta jose negrete y se mostrara Jose Negrete
    public function getNameAttribute($value){
        return ucwords($value);
    }

    // relations between models 

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
