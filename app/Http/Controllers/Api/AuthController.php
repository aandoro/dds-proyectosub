<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\User;
use Validator;
use Log;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [   
            'name' => 'required',
            'surname' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role'=> 'required', 
        ]);
        if ($validator->fails()) {
            Log::info('entre por aca');
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        Log::info($request['role']);
     
        $input['point'] = 0;
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('AppName')->accessToken;
        
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function login()
    {
        Log::info(Auth::user());
        if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = Auth::user();
            Log:info('ROLE '.$user->role);
            $success['token'] =  $user->createToken('AppName')->accessToken;
            $success['role'] = $user->role;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function refresh()
    {
        return response()->json(['success' => true], $this->successStatus);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->token()->revoke();
        return response()->json(['success' => false], $this->successStatus);
    }
}
