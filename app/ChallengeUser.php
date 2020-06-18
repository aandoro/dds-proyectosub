<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChallengeUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'challenge_id',
        'init_challenge',
        'finish_challenge',
        'user_id'
    ];

    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
