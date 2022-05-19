<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use App\Brand;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;

class AjaxSubmitController extends Controller
{
    //
    public function productCategory(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required|unique:product_categories,name'
        ]);
        
        $pcat = new ProductCategory();
        $pcat->restaurant_id = 1;
        $pcat->name = $request->category_name;
        $pcat->created_by = \Auth::user()->email;
        if($pcat->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'data'  => $pcat ,'message' => 'Products category has been saved successfully'];
        }

        return ['type' => 'error', 'title' => 'Failed!','message' => 'Failed to save products category'];


    }

    public function brand(Request $request)
    {
        $this->validate($request, [
            'brand_name' => 'required|unique:brands,name'
        ]);
        
        $brand = new Brand();
        $brand->restaurant_id = 1;
        $brand->name = $request->brand_name;
        $brand->created_by = \Auth::user()->email;
        if($brand->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'data'  => $brand ,'message' => 'Brand has been saved successfully'];
        }

        return ['type' => 'error', 'title' => 'Failed!','message' => 'Failed to save brand'];

    }

    public function supplier(Request $request)
    {
        $this->validate($request, [
            'supplier_name' => 'required',
            'phone' => 'required|unique:suppliers|max:14|min:11|regex:/\+?(88)?0?1[56789][0-9]{8}\b/',
        ]);

        $supplier = new Supplier();
        $supplier->restaurant_id = 1;
        $supplier->name = $request->supplier_name;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->status = $request->status;
        $supplier->created_by = \Auth::user()->email;
        
        if($supplier->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'data'  => $supplier ,'message' => 'Supplier has been saved successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!','message' => 'Failed to saved supplier'];

    }

    public function unit(Request $request)
    {
        $this->validate($request, [
            'unit_name' => 'required|unique:units,name'
        ]);
        
        $unit = new Unit();
        $unit->restaurant_id = 1;
        $unit->name = $request->unit_name;
        $unit->created_by = \Auth::user()->email;
        if($unit->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'data'  => $unit ,'message' => 'Unit has been saved successfully'];
        }

        return ['type' => 'error', 'title' => 'Failed!','message' => 'Failed to save unit'];

    }
}
