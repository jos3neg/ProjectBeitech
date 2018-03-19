<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
/*********************************************/
    public function index()
    {
        $products = Product::all();
        return response()->json(['data' => $products, 'message' => 'Lista de Productos'], 200);
    }

    /*********************************************/
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required|numeric',
            'product_description' => 'required'
        ];

        $this->validate($request, $rules);

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->product_description = $request->product_description;
        $product->save();

        return response()->json(['data' => $product,'message' => 'Producto Registrado'],200);
        
    }

/*********************************************/
    public function show(Product $product)
    {
        $product_find = Product::findOrFail($product->id);

        return response()->json(['data' => $product_find, 'message' => 'Mostrando Producto'], 200);
    }

/*********************************************/
    public function update(Request $request, Product $product)
    {
        if($request->has('name') && $product->name != $request->name){
            $product->name = $request->name;
        }
        if($request->has('price') && $product->name != $request->price){
            $product->price = $request->price;
        }
        if($request->has('product_description') && $product->product_description != $request->product_description){
            $product->product_description = $request->product_description;
        }

        if(!$product->isDirty()){
            return response()->json(['error' => 'No hay modificaciones', 'code' => 422],422);
        }

        $product->save();
        return response()->json(['data' => $product, 'message' => 'Producto Actualizado'],200);
    }

/*********************************************/
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['data' => $product, 'message' => 'Producto Eliminado'],200);
    }
}
