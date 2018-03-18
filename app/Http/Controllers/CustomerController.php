<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
/********************************************/
    public function index()
    {
        $customers = Customer::all();
        return response()->json(['data' => $customers,'message' => 'Lista de Clientes'],200);
    }

/********************************************/
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:customers'
        ];

        $this->validate($request, $rules);
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->save();

        return response()->json(['data' => $customer, 'message' => 'Cliente Registrado'], 201);
    }

/********************************************/
    public function show(Customer $customer)
    {
        $customer_find = Customer::findOrFail($customer->id);

        return response()->json(['data' => $customer_find, 'message' => 'Mostrando Cliente'],200);
    }

/********************************************/
    public function update(Request $request, Customer $customer)
    {
        $rules = [
            'email' => 'email|unique:customers,email,'.$customer->id
        ];
        $this->validate($request, $rules);
        
        if($request->has('name')){
            $customer->name = $request->name;
        }

        if( $request->has('email') && $customer->email != $request->email ){
            $customer->email = $request->email;
        }

        if(!$customer->isDirty()){
            return response()->json(['error' => 'No hay modificaciones', 'code' => 422], 422);
        }

        $customer->save();

        return response()->json(['data' => $customer, 'message' => 'Cliente Actualizado'] ,200);
    }

/********************************************/
    public function destroy(Customer $customer)
    {
        $customer_find = Customer::findOrFail($customer->id);
        $customer_find->delete();
        return response()->json(['data' => $customer_find, 'message' => 'Cliente Eliminado'], 200);
    }
}
