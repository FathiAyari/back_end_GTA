<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Orders;
use App\Models\PreOrder;
use App\Models\Product;
use App\Models\StockHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function getProducts()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return response()->json($products, 200);
    }

    public function getProduct($id)
    {
        $product = Product::find($id);

        return response()->json($product, 200);

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
            'type' => "add",
            'body' => "$product->name has been created at "
                . Carbon::now()->toDateTimeString() . "\nAvailable space : $request->available_space \n"
                . "Quantity : $request->quantity \n"
                . "Price : $request->price",
        ]);
        return response()->json($product, 200);
    }


    public function supplyProduct(Request $request)
    {
        $product = Product::find($request->id);
        $product->quantity = $product->quantity + $request->quantity;
        $product->save();
        StockHistory::create([

            'type' => "supply",
            'body' => "$product->name has been supplied at " . Carbon::now()->toDateTimeString() . " with $request->quantity units",
        ]);
        return response()->json($product, 200);
    }


    public function order($id,$cmp)
    {
        $preOrders = PreOrder::where("user_id", $id)->get();
        foreach ($preOrders as $preOrder){
         if($preOrder->quantity<=$preOrder->product->quantity){
             $product=Product::find($preOrder->product_id);
             $quantity=$product->quantity-$preOrder->quantity;
             $product->quantity=$quantity;
             StockHistory::create([
                 'type' => "order",
                 'body' => "$product->name has been ordered at " . Carbon::now()->toDateTimeString() .
                     " with $preOrder->quantity  item  to " . $cmp
             ]);
             $product->save();
             $preOrder->delete();
         }

        }


        $order = Orders::create([
            'created' => Carbon::parse(Carbon::now())->format('Y-m')
        ]);

        return response()->json(2, 200);
    }

}
