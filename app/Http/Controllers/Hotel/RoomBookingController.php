<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RoomBooking;
use App\Guest;
use App\Room;
use App\BookingRoomMapping;
use Carbon\Carbon;
use DB;
use Auth;
class RoomBookingController extends Controller
{
    public function index()
    {
//        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', '2015-4-9 3:30:34');
//        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', '2015-4-6 3:30:54');
//
//
//        $diff_in_minutes = $to->diffForHumans($from);
//        dd(Carbon::now()->diffInMonths($from));
//        dd($diff_in_minutes); // Output: 20
//

        $data = [
            'page_title' => 'Room Booking List :: Jannat Restaurant & Resort',
            'page_header' => 'Booking List',
            'page_desc' => '',
            'guests' => Guest::all(),
            'rooms'  => Room::all(),
            'roombookings'  => RoomBooking::all(),
            'bookingroommappings'  => BookingRoomMapping::all(),
            'guestList' => Guest::all(),
        ];

        return view('hotel.roombooking.index')->with(array_merge($this->data,$data));
    }

    //store Room data

    public function store(Request $request)
    {
       
        $this->validate($request, [
            'guest_id'      => 'required',
            'room_id'    => 'required',
            'adult'  => 'required',
            'arrival'   => 'required',
            'departure'     => 'required',
        ]);

        try{

            DB::beginTransaction();
            
            //booking
            // $roomstatus = Room::find($request->room_id);
            // $roomstatus->status = 2;
            // $roomstatus->save();
            $roombooking                           = new RoomBooking();
            $y =Carbon::now()->format('y');
            $m = Carbon::now()->format('m');
            $d = Carbon::now()->format('d');
            $prefix = $y.$m.$d;
            //existing order_no check
            $roombookings = RoomBooking::latest()->get();
            if(count($roombookings) > 0) {
                $booking_no = $roombookings->first()->booking_no;
                $div = explode($prefix, $booking_no);

                if(isset($div[1])){
                    $booking_no++;
                } else {
                    $booking_no = $prefix.'0001';
                }
            }
            else {
                //if there is no order no in table [first order ino]
                $booking_no = $prefix . '0001';
            }
            $roombooking->booking_no              = $booking_no;
            $roombooking->guest_id                 = $request->guest_id;
            $roombooking->adults                   = $request->adult;
            $roombooking->children                 = $request->children;
            $roombooking->arrival                  = $request->arrival;
            $roombooking->departure                = $request->departure;
            $roombooking->in_time                  = $request->checkInTime;
            $roombooking->out_time                 = $request->checkOutTime;
            $roombooking->created_by               = \Auth::user()->email;
            $roombooking->save();

            //booking to room maping

            $booking_rooms = $request->room_id;
            if($booking_rooms) {
                foreach ($booking_rooms as $room) {
                    $bookingroom = new BookingRoomMapping();
                    $bookingroom->room_booking_id = $roombooking->id;
                    $bookingroom->room_id = $room;
                    $bookingroom->save();
                }
            }

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('roombooking'), 'message' => 'Room Booked successfully'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Room Booking'];
        }
    }

    //for view data
    public function edit($id)
    {
        $roombooking = RoomBooking::find($id);
        $bookingroommapping=BookingRoomMapping::with('roomcategory','room','roomBooking')->where('room_booking_id',$id)->get();
        $data = [
            'page_title'            => 'Edit Room Booking',
            'page_header'           => 'Edit Room Booking',
            'page_desc'             => '',
            'guests'                => Guest::all(),
            'rooms'                 => Room::all(),
            'roombookings'          => $roombooking,
            'bookingroommappings'   => $bookingroommapping,
            'roombookins'  => RoomBooking::all(),
            'bookingroommappins'  => BookingRoomMapping::all(),

        ];

        return view('hotel.roombooking.edit')->with(array_merge($this->data, $data));
    }

    //update roombooking
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'guest_name'      => 'required',
            'room_id'    => 'required',
            'adult'  => 'required',
            'arrival'   => 'required',
            'departure'     => 'required',
        ]);

        try{

            DB::beginTransaction();

            //booking
            // $roomstatus = Room::find($request->room_id);
            // $roomstatus->status = 2;
            // $roomstatus->save();
            $roombooking                           = RoomBooking::find($id);
            $roombooking->guest_id                 = $request->guest_name;
            $roombooking->adults                   = $request->adult;
            $roombooking->children                 = $request->children;
            $roombooking->arrival                  = $request->arrival;
            $roombooking->departure                = $request->departure;
            $roombooking->in_time                  = $request->checkInTime;
            $roombooking->out_time                 = $request->checkOutTime;
            $roombooking->created_by               = \Auth::user()->email;
            $roombooking->save();

            //booking to room maping
            //menu to manutoproduct maping
            BookingRoomMapping::where('room_booking_id', $id)->delete();
            $booking_rooms = $request->room_id;
            if($booking_rooms) {
                foreach ($booking_rooms as $room) {
                    $bookingroom = new BookingRoomMapping();
                    $bookingroom->room_booking_id = $roombooking->id;
                    $bookingroom->room_id = $room;
                    $bookingroom->save();
                }
            }

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('roombooking'), 'message' => 'Room Booked successfully'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Room Booking'];
        }
    }

    //delete menu
    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $roombooking = RoomBooking::find($id);
        $roombooking->deleted_by = \Auth::user()->email;
        $roombooking->save();
        if ($roombooking->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }
}
