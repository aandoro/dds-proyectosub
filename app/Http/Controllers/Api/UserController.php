<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;

use Log;

class UserController extends Controller
{
    public function index()
    {
        /* $users = User::orderBy('id')->paginate(20); */
        $users = DB::table('users')->where('role', '!=', 3)->where('deleted_at', '=', null)->get();
        return UserResource::collection($users);
    }

    public function store(Request $request)
    { }

    public function show($id)
    {
        $user = User::find($id);

        Log::info('USER ' . $user);
        return new UserResource($user);
    }


    public function update($id, Request $request)
    {

     /*   $this->validate($request, [
            'name' => 'required',
            'surname' => 'required',
            'username' => 'required',
            'email' => 'required',
            'point' => 'required',
            'password' => 'required',
            'c_password' => 'required',
            'role' => 'required',
        ]);  */
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required',
            'username' => 'required',
            'email' => 'required',
            'point' => 'required',
        ]);


        $user = User::find($id);

        $user->name = $request['name'];
        $user->surname = $request['surname'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->point = $request['point'];
        $user->save();

        return new UserResource($user);
    }


    public function findByUsername(Request $request)
    {

        $user = DB::table('users')->where('username', '=', $request['username'])->get();
        return new UserResource($user[0]);
    }

    public function findUserMobile()
    {
        $users = DB::table('users')->where('role', '=', 3)->get();
        return UserResource::collection($users);
    }

    public function deleteByUserMovil($id)
    {
        $user = User::find($id);
        $user->delete();
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return new UserResource($user);
    }
}
