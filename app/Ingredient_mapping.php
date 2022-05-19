<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ingredient_mapping extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $primaryKey = 'menu_id';

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
