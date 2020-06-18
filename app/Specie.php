<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'scientificName',
        'description',
        'diet',
        'habitat',
        'reproduction',
        'group_id'
    ];


    public function group()
    {
        // return $this->belongsTo('Group', 'group_id');
        return $this->belongsTo(Group::class);
    }

    public function imageSpecie()
    {
        return $this->hasOne(ImageSpecie::class);
    }
/* 
    public function delete()
    {
        DB::transaction(function () {
            $this->group()->delete();
            parent::delete();
        });
    } */
}
