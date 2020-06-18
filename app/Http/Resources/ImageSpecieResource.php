<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ImageSpecieResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'image' => $this->image,
            'specie_id' => $this->specie_id
        ];
    }
}
