<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class order_menu_mapping extends Model
{
    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }
}
