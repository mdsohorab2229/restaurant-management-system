<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['guest_phone'];

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function getGuestPhoneAttribute()
    {
        return $this->attributes['name'].' ('.$this->attributes['phone'].')';
    }
}
