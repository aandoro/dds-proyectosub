<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trivia extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 
        'description',
        'question', 
        'optCorrect',
        'point', 
        'level_id', 
        'category_id'];

    public function options()
    {
        return $this->hasMany(Option::class);
    }


}
