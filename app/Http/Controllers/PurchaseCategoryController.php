<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Purchase_category;

class PurchaseCategoryController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Purchase Category List :: Jannat Restaurant & Resort',
            'page_header' => 'Purchase Categories',
            'page_desc' => '',
            'purchase_categories' => Purchase_category::all()
        ];

        return view('purchasecategory.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:purchase_categories'
        ]);

        $purcat = new Purchase_category();
        $purcat->name = $request->name;
        $purcat->created_by = \Auth::user()->email;
        if($purcat->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('purchase-category') ,'message' => 'Purchase Category Stored Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Purchase Category Successfully'];

    }
    public function edit(Request $request)
    {
        $data =  Purchase_category::find($request->category_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:purchase_categories,name,'.$request->category_id
        ]);

        $purcat = Purchase_category::find($request->category_id);
        $purcat->name = $request->name;
        $purcat->updated_by = \Auth::user()->email;
        if($purcat->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('purchase-category') ,'message' => 'Purchase Category Updated Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Update Purchase Category Successfully'];
    }

    public function destroy($id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $purcat = Purchase_category::find($id);
        $purcat->deleted_by = \Auth::user()->email;
        $purcat->save();
        if ($purcat->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'The Purchase Category Deleted Successfully.'];
        }
    }
}
