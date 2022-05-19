<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Banklist;

class BanklistController extends Controller
{
    public function banklistindex()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Bank List :: Jannat Restaurant & Resort',
            'page_header' => 'Bank List',
            'page_desc' => '',
            'banklists' => Banklist::all()
        ];

        return view('banks.banklists.index')->with(array_merge($this->data,$data));
    }

    public function bankliststore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:banklists'
        ]);

        $banklist = new Banklist();
        $banklist->name = $request->name;
        $banklist->status = $request->status;
        $banklist->created_by = \Auth::user()->email;
        if($banklist->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('banklist') ,'message' => 'Data Stored Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Brand Category Successfully'];
    }

    public function banklistedit(Request $request)
    {
        $data =  Banklist::find($request->banklist_id);

        return $data;
    }

    public function banklistupdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:banklists,name,'.$request->banklist_id,
        ]);

        $banklist = Banklist::find($request->banklist_id);
        $banklist->name = $request->name;
        $banklist->status = $request->status;
        $banklist->updated_by = \Auth::user()->email;
        if($banklist->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('banklist') ,'message' => 'Data Updated Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Updated Data Successfully'];

    }

    public function banklistdestroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $banklist = Banklist::find($id);
        $banklist->deleted_by = \Auth::user()->email;
        $banklist->save();
        if ($banklist->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }
}
