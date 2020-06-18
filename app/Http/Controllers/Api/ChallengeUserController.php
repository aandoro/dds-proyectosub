<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\ChallengeUser;
use App\Http\Resources\ChallengeUserResource;
use App\Image;
use Log;

class ChallengeUserController extends Controller
{
    public function index()
    {
        $cUsers = ChallengeUser::orderBy('id')->paginate(20);
        return ChallengeUserResource::collection($cUsers);
    }

    public function store(Request $request)
    {
        $cUser = $this->validate($request, [
            'init_challenge' => 'required',
            'finish_challenge' => 'required',
            'challenge_id' => 'nullable',
            'user_id' => 'nullable',
        ]);

        $cUser = ChallengeUser::create($cUser);

        return new ChallengeUserResource($cUser);
    }

    public function show($id)
    {
        $cUser = ChallengeUser::find($id);
        return new ChallengeUserResource($cUser);
    }

    public function update($id, Request $request)
    { }

    public function destroy($id)
    { }
}
