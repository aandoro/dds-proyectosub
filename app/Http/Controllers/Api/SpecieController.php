<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Specie;
use App\Http\Resources\SpecieResource;
use Illuminate\Support\Facades\DB;
use Log;

class SpecieController extends Controller
{
    public function index()
    {
        $species = Specie::orderBy('id')->paginate(20);
        return SpecieResource::collection($species);
    }

    public function store(Request $request)
    {
        $specie = $this->validate($request, [
            'name' => 'required',
            'scientificName' => 'nullable',
            'description' => 'required',
            'diet' => 'required',
            'habitat' => 'required',
            'reproduction' => 'required',
            'image' => 'nullable',
            'group_id' => 'required'
        ]);

        $specie = Specie::create($specie);



        /* if (null($request['image'])) {
            $specie->imageSpecie()->create([
                'image' => 'default_specie.jpg'
            ]);
        } else {
            Log::info("ENTRE AL ELSE"); */
        preg_match('/data:image\/(\\w+);base64,([\\s\\S]+)/', $request['image'], $matches);
        $name = time() . '.' . $matches[1];

        Storage::disk('imgspecie')->put($name, base64_decode($matches[2]));
        $specie->imageSpecie()->create([
            'image' => $name
        ]);
        /* } */


        return new SpecieResource($specie);
    }

    public function show($id)
    {
        $specie = Specie::find($id);
        return new SpecieResource($specie);
    }


    public function findByGroup($group)
    {
        $species = DB::table('species')->where('group_id', '=', $group)->get();
        return SpecieResource::collection($species);
    }



    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'scientificName',
            'description' => 'required',
            'diet' => 'required',
            'habitat' => 'required',
            'reproduction' => 'required',
            'image' => 'nullable',
            'group_id' => 'required'
        ]);

        $specie = Specie::find($id);
        $specie->name = $request['name'];
        $specie->description = $request['description'];
        $specie->group_id = $request['group_id'];

        $specie->save();

        preg_match('/data:image\/(\\w+);base64,([\\s\\S]+)/', $request['image'], $matches);
        $name = microtime(true) . "." . $matches[1];

        Storage::disk('imgspecie')->put($name, base64_decode($matches[2]));
        $images = app('App\Http\Controllers\Api\ImageSpecieController')->findBySpecie($id);

        /* if (empty($images)) { */
        $specie->imageSpecie()->update([
            'image' => $name
        ]);
        /*   } else {
            $specie->imageSpecie()->update([
                'image' => $name
            ]);
        } */

        return new SpecieResource($specie);
    }

    public function destroy($id)
    {
        $specie = Specie::find($id);
        $specie->imageSpecie()->delete();
        $specie->delete();

        //  return back()->with('success', 'borrado con exito');
        return new SpecieResource($specie);
    }
}
