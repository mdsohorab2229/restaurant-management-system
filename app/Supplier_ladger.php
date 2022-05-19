<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Supplier_ladger extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function getDateAttribute()
    {
        return user_formatted_date($this->attributes['date']);
    }
}
