<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Challenge extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'description', 'point', 'picCount', 'level_id', 'category_id'];
}
