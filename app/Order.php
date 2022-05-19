<?php

namespace App;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // use SoftDeletes;
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    public function table()
    {
        return $this->belongsTo('App\Table');
    }

    public function user()
    {
        return $this->belongsTo('App\User','waiter_id','id');
    }

    public function chief()
    {
        return $this->belongsTo('App\User','chief_id','id');
    }

    public function getCreatedAtAttribute()
    {
        return user_formatted_datetime($this->attributes['created_at']);
    }
  

}
