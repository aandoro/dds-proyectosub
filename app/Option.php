<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use SoftDeletes;
    protected $fillable = ['option', 
    'trivia_id'];

    public function trivia()
    {
        // return $this->belongsTo('Group', 'group_id');
        return $this->belongsTo(Trivia::class);
    }

    public function delete()
    {
        DB::transaction(function () {
            $this->trivia()->delete();
            parent::delete();
        });
    }
}
