<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Challenge;
use App\Http\Resources\ChallengeResource;
use Illuminate\Support\Facades\DB;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::orderBy('id')->paginate(20);

        return ChallengeResource::collection($challenges);
    }

    public function store(Request $request)
    {
        $challenge = $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'level_id' => 'required',
            'category_id' => 'required',
            'picCount' => 'required',
            'point' => 'required'
        ]);

        $challenge = Challenge::create([
            'name' => $challenge['name'],
            'description' => $challenge['description'],
            'level_id' => $challenge['level_id'],
            'category_id' => $challenge['category_id'],
            'picCount' => $challenge['picCount'],
            'point' => $challenge['point'],

        ]);

        return new ChallengeResource($challenge);
    }

    public function show($id)
    {
        $challenge = Challenge::find($id);
        return new ChallengeResource($challenge);
    }

    public function findByLevel($level)
    {
        $challenges = DB::table('challenges')->where('level_id', '=', $level)->get();
        return ChallengeResource::collection($challenges);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'level_id' => 'required',
            'category_id' => 'required',
            'picCount' => 'required',
            'point' => 'required'
        ]);

        $challenge = Challenge::find($id);
        $challenge->name = $request['name'];
        $challenge->description = $request['description'];
        $challenge->level_id = $request['level_id'];
        $challenge->category_id = $request['category_id'];
        $challenge->point = $request['point'];
        $challenge->picCount = $request['picCount'];

        $challenge->save();

        return new ChallengeResource($challenge);
    }

    public function destroy($id)
    {
        Challenge::find($id)->delete();
    }
}
