<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Weather;
use App\Http\Resources\WeatherResource;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log as FacadesLog;
use Log;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weathers = Weather::orderBy('id')->paginate(20);
        return WeatherResource::collection($weathers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function findByDates(Request $request)
    {
        $fecha = intval(date('H', strtotime($request['init_challenge'])));
        $fecha1 = date('Y-m-d', strtotime($request['finish_challenge']));

        Log::info('weather: ' . $fecha);
        Log::info('lat '.$request['lat']);
        Log::info('lon '.$request['lon']);


        while ($fecha % 3 != 0) {
            $fecha++;
            Log::info('fecha' . $fecha);
        }
        Log::info('es multiplo de 3');
        $fechaString = $fecha1 . ' ' . $fecha . ':00:00';
        Log::info('fecha1 ' . $fechaString);

        //$weather = Weather::where('lat','<=',$request['lat'])->where('lon','>',$request['lon'])->where('date', '=', $fechaString)->get();
        $weather = Weather::where('cityname','=',$request['name'])->where('date', '=', $fechaString)->get();
        Log::info('weather: ' . $weather);
        return WeatherResource::collection($weather);
    }
}
