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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'created_by' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $activite = Activite::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
            'created_by' => $request->created_by,
        ]);


        return response()->json(['status' => 'success', 'data' => $activite]);
    }

    public function deleteactivite($id)
    {
        $post = Activite::find($id);

        if (!$post) {
            return response([
                'message' => 'activity not found.'
            ], 403);
        }

        /* if($post->fk_account != auth()->user()->id)
         {
             return response([
                 'message' => 'Permission denied.'
             ], 403);
         }*/


        $post->delete();


        return response([
            'message' => 'Activity deleted.'
        ], 200);
    }


    public function updateactivites($id)
    {

        $post = Activite::find($id);

        if (!$post) {
            return response([
                'message' => 'activite not found.'
            ], 403);
        }

        $post->name = $request->input('name');
        $post->description = $request->input('description');
        $post->color = $request->input('color');

        return response([
            'message' => 'Population updated.',
            'planning' => $post
        ], 200);
    }


}
