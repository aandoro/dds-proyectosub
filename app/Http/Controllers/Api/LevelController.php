<?php

namespace App\Http\Controllers\Api;

use App\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;

class LevelController extends Controller
{

    public function index()
    {
        $leveles = Level::orderBy('id')->paginate(20);

        return LevelResource::collection($leveles);
    }

    public function store(Request $request)
    {
        $level = $this->validate($request, [
            'name' => 'required',
            'scoreRequired' => 'required',
            'number' => 'required'
        ]);

        $level = Level::create($level);

        $level->number = $level->id;

        $level->save();

        return new LevelResource($level);
     }

    public function show($id)
    {
        $level = Level::find($id);
        return new LevelResource($level);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'scoreRequired' => 'required',
        ]);


        $level = Level::find($id);
        $level->name = $request['name'];
        $level->scoreRequired = $request['scoreRequired'];

        $level->save();

        return new LevelResource($level);
    }

    public function destroy($id)
    {
        $level = Level::find($id);
        $level->delete();
        return new LevelResource($level);
    }
}
