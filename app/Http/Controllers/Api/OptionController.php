<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Option;
use App\Http\Resources\OptionResource;
//use PHPUnit\Util\Json;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::orderBy('id')->paginate(20);
        return OptionResource::collection($options);
    }

    public function store(Request $request)
    {
        $option = $this->validate($request, [
            'option' => 'required',
            'trivia_id' => 'required'
        ]);

        $option = Option::create($option);
        return new OptionResource($option);
    }

    public function show($trivia_id)
    {
        $options = Option::select('option')->where('trivia_id', $trivia_id)->get();
        return $options;
    }

    public function update($id, Request $request)
    { }

    public function destroy($id)
    { }
}
