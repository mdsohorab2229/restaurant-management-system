<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Guest;
use Datatables;
use Form;
use DB;
use Auth;
use Carbon\Carbon;
use App\RoomCategory;
use App\Room;
use App\RoomBooking;
use App\GuestPayment;
class AjaxDataController extends Controller
{
    //for Guest
    public function getGuestData()
    {
        $i = 1;
        $guests = Guest::with(['district']);
        return Datatables::of($guests)
            ->addColumn('action', function($guest){
                return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$guest->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['guest.destroy', $guest->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($guest) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for Room Category
    public function getroomcategoryData()
    {
        $i = 1;
        $roomcategories = RoomCategory::all();
        return Datatables::of($roomcategories)
            ->addColumn('action', function($roomcategory){
                return '<button class="btn btn-xs btn-primary edit_data" data-toggle="modal" data-target="#edit_modal" id="'.$roomcategory->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['roomcategory.destroy', $roomcategory->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($roomcategory) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for Room 
    public function getroomData()
    {
        $i = 1;
        $rooms = Room::with(['roomcategory']);
        return Datatables::of($rooms)
            ->addColumn('action', function($room){
                return '<button class="btn btn-xs btn-primary edit_data" data-toggle="modal" data-target="#edit_modal" id="'.$room->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['room.destroy', $room->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($room) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for Room Booking
    public function getroombookingData()
    {
        $i = 1;
        $roombookings = RoomBooking::with(['guest']);
        return Datatables::of($roombookings)
            ->addColumn('action', function($roombooking){
                return '<button class="btn btn-xs btn-primary edit_data" data-toggle="modal" data-target="#edit_modal" id="'.$roombooking->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['roombooking.destroy', $roombooking->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($roombooking) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for Guest
    public function getGuestPaymentData()
    {
        $i = 1;
        $payments = GuestPayment::with(['roombooking', 'guest']);
        return Datatables::of($payments)
            ->addColumn('action', function($payment){
                return '
            '.Form::open(['route' => ['guestPayment.destroy', $payment->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($guest) use(&$i){
                return $i++;
            })
            ->make(true);
    }

}
