<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeUserResource extends JsonResource
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
            'challenge_id' => $this->challenge_id,
            'init_challenge' => $this->init_challenge,
            'finish_challenge' => $this->finish_challenge,
            'user_id' => $this->user_id
        ];
    }
}
