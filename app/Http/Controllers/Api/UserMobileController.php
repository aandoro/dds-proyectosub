<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserMobile;
use App\Http\Resources\UserMobileResource;

class UserMobileController extends Controller
{
    
    public function index()
    {
        $userMobiles = UserMobile::orderBy('id')->paginate(20);
        return UserMobileResource::collection($userMobiles);
    }

    public function store(Request $request)
    {
        $request['point'] = 0;
        $userMobile = $this->validate($request, [
            'name' => 'required',
            'point' => 'required',
            'email' => ['required', 'unique:UserMobiles'],
            'password' => 'required'
        ]);


        $userMobile = UserMobile::create($userMobile);



        return new UserMobileResource($userMobile);
    }


    public function findEmail(Request $request)
    {
        $userMobile =  UserMobile::where("email", $request['email'])
            ->where('password', $request['password'])
            ->get();

        return new UserMobileResource($userMobile[0]);
    }

    public function show($id)
    {
        $userMobile = UserMobile::find($id);
        return new UserMobileResource($userMobile);
    }

    public function update($id, Request $request)
    { }

    public function destroy($id)
    { }
}
