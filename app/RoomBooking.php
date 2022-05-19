<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RoomBooking extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'room_bookings';

    public function guest()
    {
        return $this->belongsTo('App\Guest');
    }

    public function roomcategory()
    {
        return $this->belongsTo('App\RoomCategory');
    }

    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    public function bookingRooms()
    {
        return $this->hasMany('App\BookingRoomMapping');
    }
}
