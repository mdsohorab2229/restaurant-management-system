<?php

namespace App\Http\Controllers;

use Auth;
use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    //
    public function index()
    {
        $data = [
            'page_title' => 'Units :: Jannat Restaurant & Resort',
            'page_header' => 'Units List',
            'page_desc' => '',
            'units' => Unit::all()
        ];

        return view('units.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:units',
            'shortname' => 'required'
        ]);

        $unit = new Unit();
        $unit->name = $request->name;
        $unit->shortname = $request->shortname;
        $unit->created_by = \Auth::user()->email;
        if($unit->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('units') ,'message' => 'Unit has been added successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrongs'];

    }
    public function edit(Request $request)
    {
        $data =  Unit::find($request->unit_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:units,name,'.$request->unit_id
        ]);

        $unit = Unit::find($request->unit_id);
        $unit->name = $request->name;
        $unit->shortname = $request->shortname;
        $unit->updated_by = \Auth::user()->email;
        if($unit->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('units') ,'message' => 'Units Updated Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Update Unit'];
    }

    public function destroy($id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $unit = Unit::find($id);
        $unit->deleted_by = \Auth::user()->email;
        $unit->save();
        if ($unit->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Units Deleted Successfully.'];
        }
    }
}
