<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Menu_menucategory_mapping extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $primaryKey = 'menu_id';

    public function menuCategory()
    {
        return $this->belongsTo('App\MenuCategory');
    }

    
}
