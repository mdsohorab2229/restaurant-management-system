<?php

namespace App\Http\Controllers;
use App\ProductCategory;
use Illuminate\Http\Request;
use Auth;
class ProductCategoryController extends Controller
{
    // view all Product Category

    public function index()
    {
        $data = [
            'page_title' => 'Product Category List :: Jannat Restaurant & Resort',
            'page_header' => 'Product Category List',
            'page_desc' => '',
            'product_categories' => ProductCategory::all()
        ];

        return view('productcategories.index')->with(array_merge($this->data, $data));
    }

   // Store Product Categroy In Database

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_categories'
        ]);

        $pcat = new ProductCategory();
        $pcat->restaurant_id = 1;
        $pcat->name = $request->name;
        $pcat->created_by = \Auth::user()->email;
        if($pcat->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('product.categories') ,'message' => 'Product Category Stored Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Product Category Successfully'];

    }
    // Show Edit Product Categroy  

    public function edit(Request $request)
    {
        $data =  ProductCategory::find($request->category_id);

        return $data;
    }

    // Updata Product Categry

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_categories'   
        ]);

        $pcat = ProductCategory::find($request->category_id);
        $pcat->name = $request->name;
        $pcat->updated_by = \Auth::user()->email;
        if($pcat->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('product.categories') ,'message' => 'Product Category Stored Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Product Category Successfully'];

    }
    
    //Delete Product Categroy

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }   
        $pcat = ProductCategory::find($id);
        $pcat->deleted_by = \Auth::user()->email;
        $pcat->save();
        if ($pcat->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'The Product Category has been deleted successfully.'];
        }
    }
    

    
}
