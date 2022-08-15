<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\HistoryType;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
   public function  getGeneralHistory(){
         $history = History::orderBy('created_at', 'desc')->get();
         return response()->json($history, 200);
   }
}
