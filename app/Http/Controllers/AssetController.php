<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assetcategory;
use App\Asset;
use Auth;
class AssetController extends Controller
{
    public function assetindex()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Asset List :: Jannat Restaurant & Resort',
            'page_header' => 'Asset List',
            'page_desc' => '',
            'assetcategories' => Assetcategory::all()
        ];

        return view('Assets.index')->with(array_merge($this->data,$data));
    }

    public function assetstore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        $asset = new Asset();
        $asset->name = $request->name;
        $asset->assetcategory_id = $request->category;
        $asset->price = $request->price;
        $asset->purchase_date = $request->purchase_date;
        $asset->quantity = $request->quantity;
        $asset->description = $request->description;
        $asset->created_by = \Auth::user()->email;
        if($asset->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('assetlist') ,'message' => 'Data Added Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Asset Category Successfully'];
    }

    public function assetedit(Request $request)
    {
        $data =  Asset::find($request->asset_id);

        return $data;
    }

    public function assetupdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        $asset = Asset::find($request->asset_id);
        $asset->name = $request->name;
        $asset->assetcategory_id = $request->category;
        $asset->price = $request->price;
        $asset->purchase_date = $request->purchase_date;
        $asset->quantity = $request->quantity;
        $asset->description = $request->description;
        $asset->updated_by = \Auth::user()->email;
        if($asset->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('assetlist') ,'message' => 'Update Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Update Successfully'];

    }

    public function assetdestroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $asset = Asset::find($id);
        $asset->deleted_by = \Auth::user()->email;
        $asset->save();
        if ($asset->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }
}
