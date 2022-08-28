<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Roles;
use App\Models\User;
use App\Models\Population;
use Carbon\Carbon;
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

    public function getusers($id)
    {
        $users = User::where('id',"!=",$id)->orderBy('created_at', 'desc')->get();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'firstname' => $user->firstname, 'lastname' => $user->lastname,
                'email' => $user->email, 'status' => $user->status,
                'role' => Roles::where("id", $user->role_id)->get()->first()->name,
                'population' => Population::where("id", $user->population_id)->get()->first()->name,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,];
        }
        return response()->json($data);

    }

    public function deleteusers($id)
    {

        $post = User::find($id);

        if (!$post) {
            return response([
                'message' => 'User not found.'
            ], 403);
        }




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
            'status' => true,
            'role_id' => $request->role_id,
            'population_id' => $request->population_id,
        ]);
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        $data = [
            'id' => $user->id,
            'firstname' => $user->firstname, 'lastname' => $user->lastname,
            'email' => $user->email, 'status' => $user->status,
            'role' => Roles::where("id", $user->role_id)->get()->first()->name,
            'population' => Population::where("id", $user->population_id)->get()->first()->name,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
        History::create([

            'type'=>"create",
            'body'=>"The Account of ".strtoupper($request->firstname." ".$request->lastname)." $request->lastname has been created at ".Carbon::now()->toDateTimeString()
        ]);
        $response = ['user' => $data, 'token' => $token];
        return response()->json($response, 200);
    }


    public function updateuser(Request $request, $id)
    {


        $user = User::find($id);


        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->population_id = $request->population_id;
        $user->role_id = $request->role_id;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }


        $user->save();



        History::create([

            'type'=>"update",
            'body'=>"The Account of ".strtoupper($user->firstname." ".$user->lastname)." has been updated at ".Carbon::now()->toDateTimeString()
        ]);
        return response()->json($user, 200);
    }


}
