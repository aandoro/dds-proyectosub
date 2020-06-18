<?php

namespace App\Console\Commands;

require_once './vendor/autoload.php';

use Illuminate\Console\Command;

use Cmfcmf\OpenWeatherMap;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

use Kreait\Firebase\Factory;

use App\Weather;
use Exception;
use Log;

class WeatherOfDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca el clima de 1 dia cada 3 horas y lo persiste en una base de datos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $database = (new Factory)
            ->withServiceAccount('./././secret/pruebafirebase-b3c3b-6c663ac78f62.json')
            ->withDatabaseUri('https://pruebafirebase-b3c3b.firebaseio.com')->createDatabase();

        $locations = $database->getReference('Locations')->getValue();
        $uid = $database->getReference('Locations')->getChildKeys();


        $lang = 'es';
        $units = 'metric';
        $myApiKey = 'ef5da1d085617b3288f469cd88890ae4';

        $httpRequestFactory = new RequestFactory();
        $httpClient = GuzzleAdapter::createWithConfig([]);

        $owm = new OpenWeatherMap($myApiKey, $httpClient, $httpRequestFactory);
        // Example 1: Get forecast for the next 5 days for Berlin
        $i = 0;
        foreach ($locations as $location) {
            try {
                //echo dd($location['name']);
                $forecast = $owm->getWeatherForecast($location['name'], $units, $lang, '', 1);

                foreach ($forecast as $weather) {
                    //echo dd(strtolower($weather->city->name));
                    $weather = Weather::create(['cityname' => strtolower($weather->city->name), 'lat' => $weather->city->lat, 'lon' => $weather->city->lon, 'date' => $weather->time->from, 'temp_min' => $weather->temperature->min, 'temp_max' => $weather->temperature->max, 'pressure' => $weather->pressure, 'humidity' => $weather->humidity, 'wind_speed' => $weather->wind->speed]);
                    //Log::info($weather);
                    //echo $weather;
                }
            } catch (Exception $e) {
                //actualizar ciudad
                Log::info($e);
                echo $location['name'];
                echo $uid[$i];
                $database->getReference('Locations/' . $uid[$i] . '/weather')->set(false);
            }
            $i = $i + 1;
        }
    }
}
