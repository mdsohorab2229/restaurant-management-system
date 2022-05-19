<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    //
    public function purchaseCategory()
    {
        return $this->belongsTo('App\Purchase_category', 'purchase_category_id', 'id');
    }
    
    public function getPurchaseDateAttribute()
    {
        return user_formatted_date($this->attributes['purchase_date']);
    }
}
