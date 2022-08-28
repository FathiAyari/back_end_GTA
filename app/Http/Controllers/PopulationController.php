<?php

namespace App\Http\Controllers;

use App\Models\Population;
use App\Models\Config;
use App\Models\ConfigGroup;
use App\Models\ConfigValue;
use App\Models\PopulationConfig;
use App\Models\PopulationConfigGroup;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Validator;

class PopulationController extends Controller
{

    public function getpopulations()
    {
        $populations = Population::all();
        foreach ($populations as $population){
            $population->plage=PopulationConfig::where("population_id",$population->id)->first();
        }

        return response()->json($populations);

    }

    public function createpopulation(Request $request)
    {


        $population = Population::create([
            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);


        return response()->json($population, 200);
    }


    public function deletepopulation($id)
    {
        $post = Population::find($id);


        $post->delete();


        return response([
            'message' => 'population deleted.'
        ], 200);
    }

    public function updatepopulation(Request $request, $id)
    {
        $post = Population::find($id);


        $post->name = $request->input('name');

        $post->save();
        return response([
            'message' => 'Population updated.',
            'planning' => $post
        ], 200);
    }

}
