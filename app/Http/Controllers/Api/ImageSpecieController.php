<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ImageSpecie;
use App\Http\Resources\ImageSpecieResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Log;

class ImageSpecieController extends Controller
{
    public function index()
    {
        $imagesSpecies = ImageSpecie::orderBy('id')->paginate(20);

        //Log::info("RUTA: " . Storage::get('/public/img/species/' . $imagesSpecies[0]->image));
        $file = Storage::get('./img/species/' . $imagesSpecies[0]->image);
        return response($file, 200)->header('Content-Type', 'image/jpeg');
        //return ImageSpecieResource::collection($imagesSpecies);
    }


    public function create()
    { }


    public function store(Request $request)
    { }

    public function show($id)
    { }

    public function findBySpecie($specieId)
    {

        $images = DB::table('image_species')->where('specie_id', '=', $specieId)->get();
        return ImageSpecieResource::collection($images);
    }


    public function update(Request $request, $id)
    { }


    public function destroy($id)
    { }
}
