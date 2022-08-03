<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Planning;
use App\Models\PlanningVersion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Validator;

class PlanningController extends Controller
{
   
    public function getplannings() {
        $plannings = Planning::all();
      
        return response()->json($plannings);

    }
    
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required|string|max:255',
            'activity' => 'required',
            'employe' => 'required',
            'status' => 'required'

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $planning_version = 'parent_verison' ;
        $planning = Planning::create([
            'code' => $request->code,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'activity' => $request->activity,
            // 'source' => $request->source,
            'employe' => $request->employe,
            // 'employee_contract' => $request->employee_contract,
            // 'employee_mat' => $request->employee_mat,
            'duration' => $request->duration,
            'planning_version' => $planning_version,
            'status' => $request->status,
            

            'user_id' => $request->user_id


        ]);
        $planningverison = PlanningVersion::create([
            'code' => $request->code,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'activity' => $request->activity,
            // 'source' => $request->source,
            'employee' => $request->employe,
            // 'employee_contract' => $request->employee_contract,
            // 'employee_mat' => $request->employee_mat,
            'duration' => $request->duration,
            'planning_version' => $planning_version,
            'status' => $request->status,
            'note' => $request->note,

            'created_by' => $request->user_id,
            'version_id' => $request->version_id,
            'parent_version' => $planning->id,
         
            


        ]);




        return response()->json(['->status'=>'success','data'=> $planning]);
    }
    public function destroy($id)
    {
        $post = Planning::find($id);

        if(!$post)
        {
            return response([
                'message' => 'planning not found.'
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
            'message' => 'planning deleted.'
        ], 200);
    }
    
    public function update(Request $request ,$id)
    {  
        
      
        $post = Planning::find($id);

        if(!$post)
        {
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
        
            
            $post->start_time =  $request->input('start_time');
            $post->end_time =  $request->input('end_time');
            $post->activity =  $request->input('activity');
      
            $post->employe =  $request->input('employe');
            $post->duration =  $request->input('duration');
            $post->status = $request->input('status');
            $post->created_by =  $request->input('user_id');
            
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
   
    public function updatestatus(Request $request ,$id)
    { 
        $post = Planning::find($id);

        if(!$post)
        {
            return response([
                'message' => 'planning not found.'
            ], 403);
        }
       
        $post->status = $request->input('status');
        $post->created_by =  $request->input('user_id');
        if($request->status == 'refusé'){
            $post->delete();
        }
        return response([
            'message' => 'planning updated.',
            'planning' => $post
        ], 200);
    }
}
