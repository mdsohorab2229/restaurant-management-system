<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RoomCategory;
use Auth;
use App\Guest;
class RoomCategoryController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Room Category List :: Jannat Restaurant & Resort',
            'page_header' => 'Room Category',
            'page_desc' => '',
            'guestList' => Guest::all(),
        ];

        return view('hotel.roomcategory.index')->with(array_merge($this->data,$data));
    }
    
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name'      => 'required|unique:room_categories',
            'rate'=> 'required',
        ]);

        $roomcategory                          = new RoomCategory();
        $roomcategory->name                    = $request->name;
        $roomcategory->rate                    = $request->rate;
        $roomcategory->created_by              = \Auth::user()->email;
        if($roomcategory->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('roomcategory') ,'message' => 'Room Category Added Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Added Room Category Successfully'];
    }

    //for view data 
    public function edit(Request $request)
    {
        $data =  RoomCategory::find($request->roomcategory_id);

        return $data;
    }

    //for update
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|unique:room_categories,name,'.$request->roomcategory_id,
            'rate'=> 'required',
        ]);

        $roomcategory                          = RoomCategory::find($request->roomcategory_id);
        $roomcategory->name                    = $request->name;
        $roomcategory->rate                    = $request->rate;
        $roomcategory->created_by              = \Auth::user()->email;
        if($roomcategory->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('roomcategory') ,'message' => 'Room Category Updated Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Updated Room Category Successfully'];
    }
    //for destroy
    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }   
        $roomcategory = RoomCategory::find($id);
        $roomcategory->deleted_by = \Auth::user()->email;
        $roomcategory->save();
        if ($roomcategory->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Category has been deleted successfully.'];
        }
    }
}
