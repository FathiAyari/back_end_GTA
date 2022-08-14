<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function stuffStats()
    {
        $employees = count(User::where("role_id", 3)->get());
        $admins = count(User::where("role_id", 2)->get());
        $super_admins = count(User::where("role_id", 1)->get());
        $stock_managers = count(User::where("role_id", 4)->get());
        $companies = 1;
        $total = $employees + $admins + $super_admins + $stock_managers + $companies;

        $data = ["employees" => round($employees / $total * 100, 0, PHP_ROUND_HALF_UP), "admins" => round($admins / $total * 100, 0, PHP_ROUND_HALF_UP), "super_admins" => round($super_admins / $total * 100, 0, PHP_ROUND_HALF_UP), "companies" => round($companies / $total * 100, 0, PHP_ROUND_HALF_UP), "stock_managers" => round($stock_managers / $total * 100, 0, PHP_ROUND_HALF_UP)];
        return response()->json($data, 200);

    }


    public function productsStats()
    {
        $products = Product::all();
        $data = [];
        foreach ($products as $product) {

            $todayOrders=count(Orders::where("product_id",$product->id)->where("created_at",Carbon::parse(Carbon::now())->format('Y-m-d'))->get());
            $quantity_percent = round($product->quantity / $product->available_space * 100, 0, PHP_ROUND_HALF_UP);
            $data[] = ["today_orders"=>$todayOrders,"id"=>$product->id,"name" => $product->name,
                "description"=>$product->description, "quantity" => $quantity_percent,
                "available_space" => 100-$quantity_percent,"price"=>$product->price,"created_at"=>$product->created_at];
        }

        return response()->json($data, 200);
    }

    public function  ordersStats()
    {
        $data = DB::table('orders')
            ->select('created_at as date', DB::raw('count(*) as quantity'))
            ->groupBy('created_at')
            ->orderBy("created_at","asc")->get();

        return response()->json($data, 200);
    }
    public function  planningStats()
    {
        $data = DB::table('plannings')
            ->select('start_time as date', DB::raw('count(*) as quantity'))
            ->groupBy('start_time')
            ->orderBy("start_time","asc")->get();
        foreach ($data as $key=>$value){
            $data[$key]->date=Carbon::parse($value->date)->format('Y-m-d');
        }

        return response()->json($data, 200);
    }
}

