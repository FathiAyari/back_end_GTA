<?php

namespace App\Http\Controllers;

use App\Models\Societe;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Validator;
class SocieteController extends Controller
{
   
    
    public function getsociete() {
        $societes = Societe::all();
        
        return response()->json($societes);

    }
  
    public function postsociete(Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $societes = Societe::create([
            'name'=> $request->name ,
          'adresse'=> $request->adresse ,
          'user_id'=> $request->user_id ,

        ]);

       

        return response()->json(['status'=>'success','data'=> $societes ]);
    }
    
    public function deletesociete($id)
    {
        $post = Societe::find($id);

        if(!$post)
        {
            return response([
                'message' => 'societe not found.'
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
            'message' => 'Societe deleted.'
        ], 200);
    }

    public function updatesociete($id){
        
        $post = Societe::find($id);

        if(!$post)
        {
            return response([
                'message' => 'activite not found.'
            ], 403);
        }
       
        $post->name = $request->input('name');
        $post->adresse =  $request->input('adress');
        $post->user_id =  $request->input('user_id');
      
        return response([
            'message' => 'Societe updated.',
            'societe' => $post
        ], 200);
    }




}
