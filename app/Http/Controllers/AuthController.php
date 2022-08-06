<?php

namespace App\Http\Controllers;

use App\Models\Population;
use App\Models\Roles;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
    //
    public function register(Request $req)
    {
        //create new user in users table
        $role_id = 1 ;
        $population_id = 1 ;
        $user = User::create([
            'firstname' => $req->firstname,
            'lastname' => $req->lastname,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'role_id' => $role_id ,
            'status' => true ,
            'population_id' => $population_id ,

        ]);
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $data=[
            'id'=>$user->id,
            'firstname'=>$user->firstname,'lastname'=>$user->lastname,
            'email'=> $user->email,'status'=>$user->status,
            'role'=>Roles::where("id",$user->role_id)->get()->first()->name,
            'population'=>Population::where("id",$user->population_id)->get()->first()->name ,
            'created_at'=>$user->created_at,
            'updated_at'=>$user->updated_at,];
        $response = ['user' => $data, 'token' => $token];
        return response()->json($response, 200);
    }

    public function login(Request $req)
    {
        // validate inputs
        $rules = [
            'email' => 'required',
            'password' => 'required|string'
        ];
        $req->validate($rules);
        // find user email in users table
        $user = User::where('email', $req->email)->first();
        // if user email found and password is correct
        if ($user && Hash::check($req->password, $user->password)) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            $data=['id'=>$user->id,'firstname'=>$user->firstname,'lastname'=>$user->lastname,
                'email'=> $user->email,'status'=>$user->status,
                'population'=>Roles::where("id",$user->role_id)->get()->first()->name ,
                'role'=>Roles::where("id",$user->role_id)->get()->first()->name ];
            $response = ['user' => $data, 'token' => $token];
            return response()->json($response, 200);

        }


        $response = ['message' => 'Incorrect email or password'];
        return response()->json($response, 400);
    }


    public function user()
    {
        return response([
            'user' => auth()->user()
        ], 200);
    }



}
