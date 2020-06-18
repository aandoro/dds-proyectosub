<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'cityname' => $this->cityname,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'date' => $this->date,
            'temp_min' => $this->temp_min,
            'temp_max' => $this->temp_max,
            'pressure' => $this->pressure,
            'humidity' => $this->humidity,
            'wind_speed' => $this->wind_speed,
        ];
    }
}
