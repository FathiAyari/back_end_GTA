<?php

namespace App\Http\Controllers;

use App\Models\StockHistory;
use Illuminate\Http\Request;

class StockHistoryController extends Controller
{public function getStockHistory()
    {
        $stockHistory = StockHistory::orderBy('created_at', 'desc')->get();
        return response()->json($stockHistory, 200);
    }
}
