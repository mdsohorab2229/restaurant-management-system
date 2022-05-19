<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_stock extends Model
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

    public function stock()
    {
        return $this->hasOne('App\Stock');
    }

    //brand
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    //category
    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'product_category_id', 'id');
    }

    //supplier
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function kitchen()
    {
        return $this->hasOne('App\Kitchen_stock');
    }

    public function wasted()
    {
        return $this->hasOne('App\Wasted_stock');
    }

    public function product_price()
    {
        return $this->hasMany('App\Product_price');
    }
}
