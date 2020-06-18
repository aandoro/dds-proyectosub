<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SpecieResource extends Resource
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
            'name' => $this->name,
            'scientificName' => $this->scientificName,
            'description' => $this->description,
            'diet' => $this->diet,
            'habitat' => $this->habitat,
            'reproduction' => $this->reproduction,
            'group_id' => $this->group_id,
            /* 'image' => $this->image */
        ];
    }
}
