<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Customerdiscount extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    //customer
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
    //discountcard
    public function discountcard()
    {
        return $this->belongsTo('App\Discountcard');
    }
}
