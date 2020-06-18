<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Trivia;
use App\Option;
use App\Http\Resources\TriviaResource;
use Illuminate\Support\Facades\DB;

class triviaController extends Controller
{
    public function index()
    {
        $trivias = Trivia::orderBy('id')->paginate(20);

        return TriviaResource::collection($trivias);
    }

    public function store(Request $request)
    {
        $trivia = $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'level_id' => 'required',
            'category_id' => 'required',
            'point' => 'required',
            'question' => 'required',
            'optCorrect' => 'required',
            'options' => 'required'
        ]);

        $trivia1 = Trivia::create([
            'name' => $trivia['name'],
            'description' => $trivia['description'],
            'question' => $trivia['question'],
            'optCorrect' => $trivia['optCorrect'],
            'point' => $trivia['point'],
            'level_id' => $trivia['level_id'],
            'category_id' => $trivia['category_id'],
        ]);

        $options = $trivia['options'];

        foreach ($options as $option) {
            Option::create([
                'option' => $option['option'],
                'trivia_id' => $trivia1->id
            ]);
        }

        return new TriviaResource($trivia1);
    }

    public function show($id)
    {
        $trivia = Trivia::find($id);
        return new TriviaResource($trivia);
    }

    public function findByLevel($level)
    {
        $trivias = DB::table('trivias')->where('level_id', '=', $level)->get();
        return TriviaResource::collection($trivias);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'level_id' => 'required',
            'category_id' => 'required',
            'point' => 'required',
            'question' => 'required',
        ]);


        $trivia = Trivia::find($id);
        $trivia->name = $request['name'];
        $trivia->description = $request['description'];
        $trivia->level_id = $request['level_id'];
        $trivia->category_id = $request['category_id'];
        $trivia->point = $request['point'];
        $trivia->question = $request['question'];
        $trivia->optCorrect = $request['optCorrect'];

        $trivia->save();

        return new TriviaResource($trivia);
    }

    public function destroy($id)
    {
        // Option::where('trivia_id', $id)->delete();
        //Trivia::where('id', $id)->delete();
        $trivia = Trivia::find($id);
        // $group->delete();
        $trivia->options()->delete();
        $trivia->delete();
        // return back()->with('success', 'borrado con exito');
        return new TriviaResource($trivia);
    }
}
