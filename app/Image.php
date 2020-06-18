<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image',
        'latitud',
        'longitud',
        'challenge_user_id'
    ];

    public function ChallengeUser()
    {
        return $this->belongsTo('App\ChallengeUser');
    }
}
