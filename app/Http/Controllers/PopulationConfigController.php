<?php

namespace App\Http\Controllers;

use App\Models\PopulationConfig;
use Illuminate\Http\Request;

class PopulationConfigController extends Controller
{

    public function createplagehoraire(Request $request)
    {
        $population = PopulationConfig::create([
            "start" => $request->start,
            "end" => $request->end,
            "days" => $request->days,
            "population_id" => $request->population_id,
        ]);

        return response($population, 200);
    }

    public function updateplagehoraire(Request $request, $id)
    {
        $population = PopulationConfig::find($id);
        $population->start = $request->start;
        $population->end = $request->end;
        $population->days = $request->days;
        $population->save();
        return response($population, 200);
    }

    public function deleteConfig($id)
    {
        $post = PopulationConfig::find($id);


        $post->delete();


        return response([
            'message' => 'population deleted.'
        ], 200);
    }
}
