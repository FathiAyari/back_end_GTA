<?php

namespace App\Http\Controllers;

use App\Models\Activite;

use App\Models\Activity;
use App\Models\Planning;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Validator;

class ActiviteController extends Controller
{

    public function getUnassignedActivites($status)
    {


        if ($status != -1) {
            $data = DB::table('activities')
                ->join('plannings', 'activities.id', '=', 'plannings.user_id')
                ->where('plannings.status', $status)
                ->select('activities.*')
                ->get();

        } else {
            if (count(Planning::all()) == 0) {
                $data = Activity::all();
            } else {
                $data = DB::table('activities')
                    ->join('plannings', 'activities.id', '!=', 'plannings.user_id')
                    ->select('activities.*')
                    ->get();

            }
        }
        return response()->json($data, 200);
    }

    public function getactivites()
    {
        $activites = Activite::all();

        return response()->json($activites);

    }

    public function postactivites(Request $request)
    {


        $activite = Activity::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'color' => $request->color,
        ]);


        return response()->json($activite, 200);
    }

    public function deleteActivity($id)
    {
        $post = Activity::find($id);


        $post->delete();


        return response([
            'message' => 'Activity deleted.'
        ], 200);
    }


    public function updateActivity(Request $request, $id)
    {

        $post = Activity::find($id);


        $post->name = $request->name;
        $post->description = $request->description;
        $post->color = $request->color;
        $post->type = $request->type;
        $post->save();
        return response([

            'activity' => $post
        ], 200);
    }


}
