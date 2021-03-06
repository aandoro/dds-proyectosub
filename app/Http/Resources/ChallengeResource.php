<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ChallengeResource extends Resource
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
            'description' => $this->description,
            'point' => $this->point,
            'picCount' => $this->picCount,
            'level_id' => $this->level_id,
            'category_id' => $this->category_id
        ];
    }
}
