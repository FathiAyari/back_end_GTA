<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Activity;
use App\Models\History;
use App\Models\Notification;
use App\Models\Planning;
use App\Models\PlanningVersion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Validator;

class PlanningController extends Controller
{

    public function getplannings()
    {
        $plannings = Planning::all();
        foreach ($plannings as $planning) {
            $planning->activity = Activity::where("id", $planning->activity_id)->get()->first();
            $planning->user = User::where("id", $planning->user_id)->get()->first();
        }

        return response()->json($plannings);

    }

    public function myPlans($id)
    {
        $plannings = Planning::where("user_id", $id)->get();
        foreach ($plannings as $planning) {
            $planning->activity = Activity::where("id", $planning->activity_id)->get()->first();
            $planning->user = User::where("id", $planning->user_id)->get()->first();
        }
        return response()->json($plannings);
    }

    public function getplanning($id)
    {
        $planning = Planning::where("id", $id)->get()->first();
        $planning->activity = Activity::where("id", $planning->activity_id)->get()->first();
        $planning->user = User::where("id", $planning->user_id)->get()->first();

        return response()->json($planning, 200);

    }

    public function createPlanning(Request $request)
    {


        $planning = Planning::create([

            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'activity_id' => $request->activity_id,
            'note' => $request->note,
            'status' => 0,
            'user_id' => $request->user_id,
            'created' => Carbon::parse(Carbon::now())->format('Y-m')


        ]);
        $user = User::find($request->user_id);
        $activity = Activity::find($request->activity_id);
        History::create([

            'type' => "plancreate",
            'body' => "Planning of activity " . $activity->name . " Affcted to  "
                . $user->firstname . " " .
                $user->lastname .
                " at " . Carbon::now()->toDateTimeString()
        ]);
        $planning->activity = Activity::where("id", $planning->activity_id)->get()->first();
        $planning->user = User::where("id", $planning->user_id)->get()->first();
        return response()->json($planning, 200);
    }

    public function deletePlanning($id)
    {
        $post = Planning::find($id);
        $plan = Planning::find($id);

        $activity = Activity::find($plan->activity_id);
        History::create([

            'type' => "plancdelete",
            'body' => "Planning of activity " . $activity->name . " has been deleted at " . Carbon::now()->toDateTimeString()
        ]);
        $post->delete();


        return response([
            'message' => 'planning deleted.'
        ], 200);
    }

    public function update(Request $request, $id)
    {


        $post = Planning::find($id);

        if (!$post) {
            return response([
                'message' => 'planning not found.'
            ], 403);
        }


        /*  if($post->fk_account != auth()->user()->id)
          {
              return response([
                  'message' => 'Permission denied.'
              ], 403);
          }*/

        // return response([

        //     'planning' => $request
        // ]);


        $post->start_time = $request->input('start_time');
        $post->end_time = $request->input('end_time');
        $post->activity = $request->input('activity');

        $post->employe = $request->input('employe');
        $post->duration = $request->input('duration');
        $post->status = $request->input('status');
        $post->created_by = $request->input('user_id');

        $post->save();
        $planningverison = PlanningVersion::create([
            'code' => $post->code,
            'start_time' => $post->start_time,
            'end_time' => $request->end_time,
            'activity' => $request->activity,
            // 'source' => $request->source,
            'employee' => $request->employe,
            // 'employee_contract' => $request->employee_contract,
            // 'employee_mat' => $request->employee_mat,
            'duration' => $request->duration,
            'note' => $request->note,
            'status' => $request->status,

            'created_by' => $request->user_id,
            'version_id' => $request->version_id,
            'parent_version' => $post->id,


        ]);
        // for now skip for post image

        return response([
            'message' => 'planning updated.',
            'planning' => $post
        ], 200);
    }

    public function updatestatus(Request $request, $id)
    {
        $post = Planning::find($id);

        if (!$post) {
            return response([
                'message' => 'planning not found.'
            ], 403);
        }

        $post->status = $request->input('status');
        $post->created_by = $request->input('user_id');
        if ($request->status == 'refusé') {
            $post->delete();
        }
        return response([
            'message' => 'planning updated.',
            'planning' => $post
        ], 200);
    }


    public function startPlan($id, $user_id)
    {
        $planning = Planning::find($id);
        if ($planning->status == 0 && $planning->user_id == $user_id) {
            $planning->status = 1;
            $planning->real_start_time = Carbon::now()->addHours(1);
            $user = User::find($user_id);
            $act = Activity::find($planning->activity_id);
            Notification::create([
                "status" => 0,
                "type" => "start",
                "body" => $user->firstname . " " . $user->lastname . " has started the planning of activity " . $act->name
            ]);
            $planning->save();
            return response($planning, 200);
        } else {
            return response("none", 400);
        }
    }

    public function finishPlanning($id, $user_id)
    {
        $planning = Planning::find($id);
        if ($planning->status == 1 && $planning->user_id == $user_id) {
            $planning->status = 2;
            $planning->real_end_time = Carbon::now()->addHours(1);
            $user = User::find($user_id);
            $act = Activity::find($planning->activity_id);
            Notification::create([
                "status" => 0,
                "type" => "end",
                "body" => $user->firstname . " " . $user->lastname . " has finished the planning of activity " . $act->name
            ]);

            $planning->save();
            $real_start = Carbon::parse($planning->real_start_time);
            $start = Carbon::parse($planning->start_time);

            if ($real_start->gt($start)) {
                Notification::create([
                    "status" => 0,
                    "created_at" => Carbon::now()->addMinute(1),
                    "type" => "summerize",
                    "body" => $user->firstname . " " . $user->lastname .
                        " has finished the planning of activity " . $act->name . " with lag of " . $start->diffInMinutes($real_start)." munites"
                ]);
            } else {
                Notification::create([
                    "status" => 0,
                    "type" => "summerize",
                    "body" => $user->firstname . " " . $user->lastname . " has finished the planning of activity " . $act->name . "in the right deadliane"
                ]);
            }
            return response($planning, 200);
        } else {
            return response("none", 400);
        }
    }
}
