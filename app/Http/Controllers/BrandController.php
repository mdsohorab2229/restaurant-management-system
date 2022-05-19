<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Auth;
class BrandController extends Controller
{
    public function index()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Brand List :: Jannat Restaurant & Resort',
            'page_header' => 'Brand List',
            'page_desc' => '',
            'brands' => Brand::all()
        ];

        return view('brands.index')->with(array_merge($this->data,$data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:brands'
        ]);

        $brand = new Brand();
        $brand->restaurant_id = 1;
        $brand->name = $request->name;
        $brand->created_by = \Auth::user()->email;
        if($brand->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('brands') ,'message' => 'Brand Stored Successfully'];
        }
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Brand Category Successfully'];
    }

    public function edit(Request $request)
    {
        $data =  Brand::find($request->brand_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:brands' 
        ]);

        $brand = Brand::find($request->brand_id);
        $brand->name = $request->name;
        $brand->updated_by = \Auth::user()->email;
        if($brand->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => back() ,'message' => 'Brand Stored Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Product Category Successfully'];

    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }   
        $brand = Brand::find($id);
        $brand->deleted_by = \Auth::user()->email;
        $brand->save();
        if ($brand->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Brand has been deleted successfully.'];
        }
    }
}
