<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class GuestPayment extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    

    public function roombooking()
    {
        return $this->belongsTo('App\RoomBooking', 'room_booking_id');
    }
    
    public function guest()
    {
        return $this->belongsTo('App\Guest', 'guest_id');
    }
    
    
}
