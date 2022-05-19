<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
