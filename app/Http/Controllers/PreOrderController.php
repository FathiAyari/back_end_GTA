<?php

namespace App\Http\Controllers;

use App\Models\PreOrder;
use App\Models\Product;
use Illuminate\Http\Request;

class PreOrderController extends Controller
{
    public function  getPrOrders($id){
        $preOrders = PreOrder::where("user_id",$id)->orderBy('created_at', 'desc')->get();
        $data=[];
        foreach ($preOrders as $preOrder){
            $data[]=[
                'id'=>$preOrder->id,
                'product'=>Product::find($preOrder->product_id),
                'quantity'=>$preOrder->quantity,
                'created_at'=>$preOrder->created_at,
                'updated_at'=>$preOrder->updated_at,
            ];
        }
        return response()->json($data, 200);
    }
    public function addPreOrder(Request $request){
        $user_id = $request->user_id;
        $products_id = $request->products_id;
        foreach ($products_id as $product_id){
          if(count(PreOrder::where("user_id",$user_id)->where("product_id",$product_id)->get())==0){
              PreOrder::create([
                  'user_id' => $user_id,
                  'product_id' => $product_id,
                  'quantity' => 1,
              ]);
          }
        }

        return response()->json(["result"=>"done"], 200);
    }

    public function deletePreOrder($id){
        $preOrder = PreOrder::find($id);
        $preOrder->delete();
        return response()->json(["result"=>"done"], 200);
    }

    public function updatePreOrder(Request $request,$id){
        $preOrder = PreOrder::find($id);
       $quantity= $request->quantity + $preOrder->quantity;
       if($quantity>=1 && $quantity<=$preOrder->product->quantity){
           $preOrder->quantity = $quantity;
           $preOrder->save();
           return response()->json(["result"=>"done"], 200);
       }

    }
}
