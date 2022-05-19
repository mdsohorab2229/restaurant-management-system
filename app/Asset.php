<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Asset extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    //assetcategory
    public function assetcategory()
    {
        return $this->belongsTo('App\Assetcategory');
    }
}
