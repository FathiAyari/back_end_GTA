<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Orders;
use App\Models\Product;
use App\Models\StockHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function getProducts()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

public function getProduct($id){
        $product= Product::find($id);
        return response()->json($product,200);

}
    public function addProduct(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->available_space = $request->available_space;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();
        StockHistory::create([
            'type'=>"add",
            'body'=>"$product->name has been created at "
                .Carbon::now()->toDateTimeString(). "\nAvailable space : $request->available_space \n"
                ."Quantity : $request->quantity \n"
                ."Price : $request->price",
        ]);
        return response()->json($product, 200);
    }


    public function supplyProduct(Request $request)
    {
        $product = Product::find($request->id);
        $product->quantity = $product->quantity + $request->quantity;
        $product->save();
        StockHistory::create([

            'type'=>"supply",
            'body'=>"$product->name has been supplied at ".Carbon::now()->toDateTimeString()." with $request->quantity units",
        ]);
        return response()->json($product, 200);
    }


    public function order(Request $request)
    {

        $product = Product::find($request->product_id);
        $product->quantity = $product->quantity - $request->quantity;
        $product->save();

       $order= Orders::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'company_id' => $request->company_id,
            'created_at' => Carbon::now()->format('Y-m-d')
        ]);
        StockHistory::create([
            'type'=>"order",
            'body'=>"$product->name has been ordered at ".Carbon::now()->toDateTimeString().
                " with $request->quantity to ".Company::where("id",$request->company_id)->first()->name
        ]);
        return response()->json($order,200);
    }

}
