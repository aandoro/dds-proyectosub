<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $fillable = [
        'cityname', 'lat', 'lon', 'date', 'temp_min', 'temp_max', 'pressure', 'humidity', 'wind_speed'
    ];
}
