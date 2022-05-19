<?php

namespace App\Http\Controllers;
use App\Bankcategory;

use Illuminate\Http\Request;
use Auth;
class BankCategoryController extends Controller
{
    public function index()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Bank Category List :: Jannat Restaurant & Resort',
            'page_header' => 'Bank Category List',
            'page_desc' => '',
            'bankcategories' => Bankcategory::all()
        ];

        return view('banks.category.index')->with(array_merge($this->data,$data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:bankcategories'
        ]);

        $bankcategory = new Bankcategory();
        $bankcategory->name = $request->name;
        $bankcategory->status = $request->status;
        $bankcategory->created_by = \Auth::user()->email;
        if($bankcategory->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('bankcategory') ,'message' => 'Data Stored Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Data Successfully'];
    }

    public function edit(Request $request)
    {
        $data =  Bankcategory::find($request->bankcategory_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:bankcategories,name,'.$request->bankcategory_id,
        ]);

        $banklist = Bankcategory::find($request->bankcategory_id);
        $banklist->name = $request->name;
        $banklist->status = $request->status;
        $banklist->updated_by = \Auth::user()->email;
        if($banklist->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('bankcategory') ,'message' => 'Data Stored Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Data Successfully'];

    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $bankcategory = Bankcategory::find($id);
        $bankcategory->deleted_by = \Auth::user()->email;
        $bankcategory->save();
        if ($bankcategory->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }
}
