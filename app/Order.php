<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\OrderDetail;
class Order extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        "customer_id", "creation_date", "delivery_address",
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    // Revisar este metodo bien ...
    public function orderDetails(){
        return $this->hasMany('App\OrderDetail');
    }
}
