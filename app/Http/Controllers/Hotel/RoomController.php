<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RoomCategory;
use App\Room;
use Auth;
use App\Guest;
class RoomController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Room List :: Jannat Restaurant & Resort',
            'page_header' => 'Room List',
            'page_desc' => '',
            'room_categories' =>RoomCategory::all(),
            'guestList' => Guest::all(),
            
        ];

        return view('hotel.room.index')->with(array_merge($this->data,$data));
    }

    //store Room data

    public function store(Request $request)
    {
       
        
        $this->validate($request, [
            'floor'      => 'required',
            'room_no'    => 'required|unique:rooms',
            'room_type'  => 'required',
            'capacity'   => 'required',
            'status'     => 'required',
        ]);

        $room                           = new Room();
        $room->floor                    = $request->floor;
        $room->room_no                  = $request->room_no;
        $room->name                     = $request->room_name;
        $room->roomcategory_id          = $request->room_type;
        $room->capacity                 = $request->capacity;
        $room->description              = $request->description;
        $room->status                   = $request->status;
        $room->created_by               = \Auth::user()->email;
        if($room->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('room') ,'message' => 'Room Save Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Saved Room Successfully'];
    }

    //for edit
    public function edit(Request $request)
    {
        $data =  Room::find($request->room_id);

        return $data;
    }

    //Update Room data

    public function update(Request $request)
    {
       
        
        $this->validate($request, [
            'floor'      => 'required',
            'room_no'    => 'required|unique:rooms,room_no,'.$request->room_id,
            'room_type'  => 'required',
            'capacity'   => 'required',
            'status'     => 'required',
        ]);

        $room                           = Room::find($request->room_id);
        $room->floor                    = $request->floor;
        $room->room_no                  = $request->room_no;
        $room->name                     = $request->room_name;
        $room->roomcategory_id          = $request->room_type;
        $room->capacity                 = $request->capacity;
        $room->description              = $request->description;
        $room->status                   = $request->status;
        $room->created_by               = \Auth::user()->email;
        if($room->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('room') ,'message' => 'Room Updated Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Updated Room Successfully'];
    }

    //for destroy

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }   
        $guest = Room::find($id);
        $guest->deleted_by = \Auth::user()->email;
        $guest->save();
        if ($guest->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Room has been deleted successfully.'];
        }
    }

}
