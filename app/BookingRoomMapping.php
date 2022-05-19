<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingRoomMapping extends Model
{
    public function roomcategory()
    {
        return $this->belongsTo('App\RoomCategory','roomcategory_id');
    }
    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    public function roomBooking(){
        return $this->belongsTo('App\RoomBooking');
    }
}
