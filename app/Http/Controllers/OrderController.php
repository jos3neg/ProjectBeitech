<?php

namespace App\Http\Controllers;

use App\Order;
use App\Customer;
use App\Product;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
/********************************************/
    public function index(Request $request)
    {
        $orders = array();

        $rules = [
            'customer_id' => 'required',
            'date_from' => 'required|date',
            'date_to' => 'required|date'
        ];

        $this->validate($request, $rules);

        // Range dates in format Y-m-d
        $range = array(date('Y-m-d', strtotime($request->date_from)),date('Y-m-d', strtotime($request->date_to)));        
        
        $orders_temp = DB::table('orders')->where('customer_id', $request->customer_id)->whereBetween('creation_date', $range)->get();
        
    
        if(count($orders_temp) == 0){
            return response()->json(['error' => 'El cliente no tiene ordenes en este rango de fecha', 'code' => 422],422);
        }

        foreach($orders_temp as $order){
            $orders[$order->id]= Order::find($order->id);
            $orders[$order->id]["order_details"] = Order::find($order->id)->orderDetails;
        }

        return response()->json(['data' => $orders, 'range' => $range],200);
    }

/********************************************/
    public function store(Request $request)
    {
        $rules = [
            'customer_id' => 'required',
            'delivery_address' => 'required',
            'product_list' => 'required',
        ];
        $this->validate($request, $rules);
        
        $customer = Customer::findOrFail($request->customer_id);

        // Products
        $products_list = $request->product_list;

        // Product allow for customer_id
        $product_customer = DB::table('customer_product')->where('customer_id', $customer->id)->get(); 
        $product_allow = array();

        foreach ($products_list as $element){
            foreach ($product_customer as $product_c){
                if($element == $product_c->product_id){
                    $product_allow[] = $element;
                }
           }
        }
        
        if(count($product_allow) > 5){
            return response()->json(['error' => 'Puede ordenar maximo 5 productos', 'code' => 422],422);
        }

        if(count($product_allow) == 0){
            return response()->json(['error' => 'Productos no permitidos', 'code' => 422 ],422);
        }
        $product_details = Product::all()->whereIn('id',$product_allow);
        $total = $product_details->sum->price;

        $order =  new Order;
        $order->customer_id = $customer->id;
        $order->total = $total;
        $order->creation_date = now();
        $order->delivery_address = $request->delivery_address;
        $order->save();

        foreach($product_details as $e){
            $order_detail = new OrderDetail;
            $order_detail->order_id = $order->id;
            $order_detail->price = $e->price;
            $order_detail->product_description = $e->product_description;
            $order_detail->save();
        }
        return response()->json(['data', $order],201);
    }
}
