<?php

namespace App\Http\Controllers;

use App\Models\Population;
use App\Models\Config;
use App\Models\ConfigGroup;
use App\Models\ConfigValue;
use App\Models\PopulationConfigGroup;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Validator;

class PopulationController extends Controller
{

    public function getpopulations() {
        $population = Population::all();
        
        return response()->json($population);

    }

    public function createpopulation(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'name_configgroup' => 'required|string',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $population = Population::create([
            'name' => $request->name,
        ]);

        $applies_to = 'population';
        $applies_at= '*';
        $configgroup = ConfigGroup::create([
            'name' => $request->name_configgroup,
            'applies_to' => $applies_to,
            'applies_at' => $applies_at,
           
        ]);
          $population_config_group= DB::table('ref01_custom_c_population_config_group')->insert(
            ['population' => $population->id, 'group' => $configgroup->id, ]
        );
        $config = Config::create([
            'name' => $request->first_day,
        ]);

        $config_group_value= DB::table('ref01_custom_c_config_value')->insert(
            ['config' => $config->id, 'group' => $configgroup->id, ]
        );

        return response()->json(['status'=>'success','data'=> $population , $configgroup ,$config ]);
    }

    public function createplagehoraire(Request $request , $id){

      
        // $validator = Validator::make($request->all(),[
        //     'end_time' => 'required|date|after:start_time',

        // ]);

        // if($validator->fails()){
        //     return response()->json($validator->errors());
        // }
        $post = PopulationConfigGroup::where('population' ,$id)->first();
        if(!$post)
        {
            return response([
                'message' => 'population  not found.'
            ], 403);
        }
        $id_group = $post->group ; 
        $group = ConfigGroup::find($id_group);

      $at = '{"hours":{"start_hour":"' . $request->start_time . '","end_hour":"' . $request->end_time . '"},"days":{' . $request->days . '}}' ;
     // $at_ =  $request->start_time  + $request->end_time  ;

        $group->applies_at = $at;
        $group->save();
        return response([
            'message' => 'Plage Horaire bien ajouté' 
        ], 200);
    }

    public function deletepopulation($id)
    {
        $post = Population::find($id);

        if(!$post)
        {
            return response([
                'message' => 'population not found.'
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
            'message' => 'population deleted.'
        ], 200);
    }
    public function updatepopulation(Request $request ,$id)
    { 
        $post = Population::find($id);

        if(!$post)
        {
            return response([
                'message' => 'planning not found.'
            ], 403);
        }
       
        $post->name = $request->input('name');
        $post->date =  $request->input('date');
      
        return response([
            'message' => 'Population updated.',
            'planning' => $post
        ], 200);
    }
    
}
