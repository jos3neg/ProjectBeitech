<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
class OrderDetail extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        "product_description", "price", "order_id",
    ];


    // relations between models
    public function Order(){
        return $this->belonsTo(Order::class);
    }
}
