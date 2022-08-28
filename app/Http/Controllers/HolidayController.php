<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function getHolidays(Request $request)
    {
        if (!$request->user_id) {
            $holidays = Holiday::where("status", $request->status)->orderBy("created_at", "desc")->get();
            foreach ($holidays as $holiday) {
                $holiday->user = User::find($holiday->user_id);
            }
            return response()->json($holidays, 200);
        } else {
            $holidays = Holiday::where("user_id", $request->user_id)->where("status", $request->status)->orderBy("created_at", "desc")->get();
            return response()->json($holidays, 200);
        }

    }


    public function createHoliday(Request $request)
    {
        $holiday = Holiday::create([
            "user_id" => $request->user_id,
            "status" => 0,
            "start" => $request->start,
            "end" => $request->end,
            "raison" => $request->raison,
            "label" => $request->label,

        ]);
        return response()->json($holiday, 200);
    }

    public function deleteRequest($id)
    {
        $request = Holiday::find($id);
        $request->delete();
        return response()->json($request, 200);
    }

    public function updateHoliday(Request $request)
    {
        $holiday = Holiday::find($request->id);
        $holiday->status = $request->status;
        $holiday->save();
        return response()->json($holiday, 200);
    }
}
