<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\District;
use App\Guest;
use App\Utility;
use Auth;

class GuestController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Guest List :: Jannat Restaurant & Resort',
            'page_header' => 'Guest List',
            'page_desc' => '',
            'districts' => District::all(),
            'guestList' => Guest::all(),
        ];

        return view('hotel.guest.index')->with(array_merge($this->data,$data));
    }

    //store guest data

    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name'      => 'required',
            'occupation'=> 'required',
            'phone'     => 'required|unique:guests|max:14|min:11|regex:/\+?(88)?0?1[56789][0-9]{8}\b/',
            'email'     => 'unique:guests',
            'district'  => 'required',
            'identity_no'  => 'required|regex:/^[0-9]+$/|unique:guests'
        ]);

        // upload photo
        if ($request->hasFile('photo')) {
            $path = Utility::file_upload($request, 'photo', 'guest_photo');
        } else {
            $path = null;
        }

        $guest                          = new Guest();
        $guest->name                    = $request->name;
        $guest->occupation              = $request->occupation;
        $guest->organization            = $request->organization;
        $guest->organization_address    = $request->organization_address;
        $guest->email                   = $request->email;
        $guest->phone                   = $request->phone;
        $guest->birthdate               = $request->birthdate;
        $guest->identity_no             = $request->identity_no;
        $guest->district_id             = $request->district;
        $guest->address                 = $request->address;
        $path ? $guest->photo           = $path : null;
        $guest->created_by              = \Auth::user()->email;
        if($guest->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('guest') ,'message' => 'Guest Added Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Added Guest Successfully'];
    }
    
    //for edit
    public function edit(Request $request)
    {
        $data =  Guest::find($request->guest_id);

        return $data;
    }

    //for Update
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'occupation'=> 'required',
            'phone'     => 'required|max:14|min:11|regex:/\+?(88)?0?1[56789][0-9]{8}\b/|unique:guests,phone,'.$request->guest_id,
            'email'     => 'unique:guests,email,'.$request->guest_id,
            'district'  => 'required',
            'identity_no'  => 'required|regex:/^[0-9]+$/|unique:guests,identity_no,'.$request->guest_id
        ]);

        // upload photo
        if ($request->hasFile('photo')) {
            $path = Utility::file_upload($request, 'photo', 'guest_photo');
        } else {
            $path = null;
        }

        $guest                          = Guest::find($request->guest_id);
        $guest->name                    = $request->name;
        $guest->occupation              = $request->occupation;
        $guest->organization            = $request->organization;
        $guest->organization_address    = $request->organization_address;
        $guest->email                   = $request->email;
        $guest->phone                   = $request->phone;
        $guest->birthdate               = $request->birthdate;
        $guest->identity_no             = $request->identity_no;
        $guest->district_id             = $request->district;
        $guest->address                 = $request->address;
        $path ? $guest->photo           = $path : null;
        $guest->updated_by              = \Auth::user()->email;
        if($guest->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('guest') ,'message' => 'Guest Updated Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Updated Guest Successfully'];
    }
    //for destroy

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }   
        $guest = Guest::find($id);
        $guest->deleted_by = \Auth::user()->email;
        $guest->save();
        if ($guest->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Guest has been deleted successfully.'];
        }
    }
}
