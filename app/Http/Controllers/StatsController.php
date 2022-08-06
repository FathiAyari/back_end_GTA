<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function stuffStats(){
        $employees=count(User::where("role_id",3)->get());
        $admins=count(User::where("role_id",2)->get());
        $super_admins=count(User::where("role_id",1)->get());
        $stock_managers=count(User::where("role_id",4)->get());
        $companies=1;
        $total=$employees+$admins+$super_admins+$stock_managers+$companies;

        $data=["employees"=>round($employees/$total *100,0,PHP_ROUND_HALF_UP),"admins"=>round($admins/$total *100,0,PHP_ROUND_HALF_UP),"super_admins"=>round($super_admins/$total *100,0,PHP_ROUND_HALF_UP),"companies"=>round($companies/$total *100,0,PHP_ROUND_HALF_UP),"stock_managers"=>round($stock_managers/$total *100,0,PHP_ROUND_HALF_UP)];
        return response()->json($data,200);

    }


    public function  productsStats(){
        $products=Product::all();
        $data=[];
        foreach ($products as $product){
            $data[]=$product;
        }
         return response()->json($data,200);
    }

}
