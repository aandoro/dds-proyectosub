<?php

namespace App\Http\Controllers\Api;

use App\ChallengeUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Image;
use App\Http\Resources\ImageResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Log;

class ImageController extends Controller
{

    public function index()
    {
        $images = Image::orderBy('id')->paginate(20);
        return ImageResource::collection($images);
    }


    public function store(Request $request)
    {
        $name = time() . '.' . $request->file('image')->getClientOriginalExtension();

        $image = Image::create([
            'image' => $name,
            'latitud' => $request['latitud'],
            'longitud' => $request['longitud'],
            'challenge_user_id' => $request['challenge_user_id']
        ]);

        $file = $request->file('image');
        Storage::disk('imgchallenge')->put($name, file_get_contents($file));

        return  new ImageResource($image);
    }

    public function findResponses($id)
    {
        $responses = Image::where("challenge_id", $id)->get();

        return json_encode($responses);
    }

    public function responseThisUser($id)
    {
        $responses = Image::where("challenge_user_id", $id)->get();

        return ImageResource::collection($responses);

    }

    public function show($id)
    {
        $image = Image::find($id);
        return new ImageResource($image);
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
