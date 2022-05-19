<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getCreatedAtAttribute()
    {
        return user_formatted_datetime($this->attributes['created_at']);
    }

  
}
