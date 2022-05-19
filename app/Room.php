<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function roomCategory()
    {
        return $this->belongsTo('App\RoomCategory', 'roomcategory_id');
    }
}
