<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserMobileResource extends Resource
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
            'surname' => $this->surname,
            'username' => $this->username,
            'point' => $this->point
        ];
    }
}
