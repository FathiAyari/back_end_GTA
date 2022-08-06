<?php

namespace App\Http\Controllers;
use App\Models\Roles;
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
        $data=[];
        foreach ($users as $user){
            $data[]=   [
                'id'=>$user->id,
                'firstname'=>$user->firstname,'lastname'=>$user->lastname,
                'email'=> $user->email,'status'=>$user->status,
                'role'=>Roles::where("id",$user->role_id)->get()->first()->name,
                'population'=>Population::where("id",$user->population_id)->get()->first()->name ,
                'created_at'=>$user->created_at,
                'updated_at'=>$user->updated_at,];
        }
        return response()->json($data);

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




        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => true ,
            'role_id' => $request->role_id ,
            'population_id' => $request->population_id,
           // 'created_by' => $request->created_by,
        ]);
        $token = $user->createToken('Personal Access Token')->plainTextToken;

       $data=[
           'id'=>$user->id,
           'firstname'=>$user->firstname,'lastname'=>$user->lastname,
           'email'=> $user->email,'status'=>$user->status,
           'role'=>Roles::where("id",$user->role_id)->get()->first()->name ,
           'population'=>Population::where("id",$user->population_id)->get()->first()->name,
           'created_at'=>$user->created_at,
           'updated_at'=>$user->updated_at,
           ];
        $response = ['user' => $data, 'token' => $token];
        return response()->json($response, 200);
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
