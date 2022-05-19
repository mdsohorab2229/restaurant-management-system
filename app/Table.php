<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function getNameAttribute()
    {
        if($this->attributes['name']) {
            return $this->attributes['name'];
        }

        return '';
    }
}
