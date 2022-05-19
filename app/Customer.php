<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['customer_phone'];

    public function customer_due()
    {
        return $this->hasMany('App\CustomerDue')->selectRaw('sum(paid) as total_paid')->groupBy('customer_id');
    }

    public function getCustomerPhoneAttribute()
    {
        return $this->attributes['name'].' ('.$this->attributes['phone'].')';
    }
}
