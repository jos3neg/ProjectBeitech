<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
class OrderDetail extends Model
{
    protected $fillable = [
        "product_description", "price", "order_id",
    ];

    public function Order(){
        return $this->belonsTo(Order::class);
    }
}
