<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Population;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getusers() {
        $users = User::all();
        return response()->json($users);

    }

    public function deleteusers($id) {
 
        $post = User::find($id);

        if(!$post)
        {
            return response([
                'message' => 'User not found.'
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
            'message' => 'user deleted.'
        ], 200);
    }
    
    public function createuser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'job' => 'required',
            'status' => 'required',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',

        ]);
   
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $name = $request->population ;
        if ($name == null ){
            $post = Population::where('name' , '=', 'gta')->first();
        }else {
            
            $post = Population::where('name' , '=', $name)->first();
        }
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'job' => $request->job,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status ,
            'fk_population' => $post->id,
            'created_by' => $request->created_by,
        ]);
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return response()->json(['status'=>'success','data'=> $post , $user]);
    }
    

    public function updateuser(Request $request ,$id)
    {  
        
        
        $post = User::find($id);

        if(!$post)
        {
            return response([
                'message' => 'user not found.'
            ], 403);
        }
        

      /*  if($post->fk_account != auth()->user()->id)
        {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }*/

        // return response([
            
        //     'user' => $request
        // ]);
        $pass = Hash::make($request->passwprd) ;
        if($request->password == null){
            $pass = $post->password ;
        }
        ;
        $name = $request->population ;
        if ($name == null ){
            $popuu = Population::where('name' , '=', 'gta')->first();
        }else {
            
            $popuu = Population::where('name' , '=', $name)->first();
        }

            $post->firstname =  $request->input('firstname');
            $post->lastname =  $request->input('lastname');
            $post->job =  $request->input('job');
            $post->fk_population = $popuu->id;
            $post->email =  $request->input('email');
            $post->password = $pass;
            $post->status = $request->input('status');
            $post->created_by = $request->input('created_by');
            
            $post->save();
         
      
        // for now skip for post image

        return response([
            'message' => 'success',
            'user' => $post
        ], 200);
    }

	
}
