<?php

namespace App\Http\Controllers;

use App\Assetcategory;
use Illuminate\Http\Request;
use Auth;

class AssetCategoryController extends Controller
{
    public function index()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Asset Category List :: Jannat Restaurant & Resort',
            'page_header' => 'Asset Category List',
            'page_desc' => '',
            'brands' => Assetcategory::all()
        ];

        return view('Assets.Assetcategory.index')->with(array_merge($this->data,$data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:assetcategories'
        ]);

        $assetcategory = new Assetcategory();
        $assetcategory->name = $request->name;
        $assetcategory->created_by = \Auth::user()->email;
        if($assetcategory->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('asset') ,'message' => 'Data Added Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Asset Category Successfully'];
    }

    public function edit(Request $request)
    {
        $data =  Assetcategory::find($request->assetcategory_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:assetcategories,name,'.$request->assetcategory_id,
        ]);

        $assetcategory = Assetcategory::find($request->assetcategory_id);
        $assetcategory->name = $request->name;
        $assetcategory->updated_by = \Auth::user()->email;
        if($assetcategory->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('asset') ,'message' => 'Added Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Successfully'];

    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $assetcategory = Assetcategory::find($id);
        $assetcategory->deleted_by = \Auth::user()->email;
        $assetcategory->save();
        if ($assetcategory->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }
}
