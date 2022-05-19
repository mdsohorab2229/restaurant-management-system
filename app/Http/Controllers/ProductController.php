<?php

namespace App\Http\Controllers;

use Auth;
use App\Stock;
use App\Product;
use App\Product_price;
use App\Brand;
use App\Supplier;
use App\Unit;
use App\ProductCategory;
use App\Kitchen_stock;
use App\Wasted_stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function index()
    {
        if(!Auth::user()->canDo(['manage_admin', 'manage_store'])){
            abort(401, 'Unauthorized Error');
        }
        $products = Product::all();
        $price = Product_price::sum('total_price');
        $data = [
            'page_title' => 'Raw Material List',
            'page_header' => 'Raw Material List',
            'page_desc' => '',
            'products' => $products,
            'total_price' => $price    
        ];

        return view('products.index')->with(array_merge($this->data, $data));
    }

    //create product form 
    public function create()
    {
        if(!Auth::user()->canDo(['manage_admin', 'manage_store'])){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title'  => 'Add Raw Materials',
            'page_header' => 'Add Raw Materials',
            'page_desc'   => '',
            'categories'  => ProductCategory::all(),
            'brands'  => Brand::all(),
            'suppliers'  => Supplier::all(),
            'units' => Unit::all()
        ];

        return view('products.create')->with(array_merge($this->data, $data));
    }

    //store product 
    public function store(Request $request)
    {
        $this->validate($request, [
            //'product_code' => 'required|unique:products',
            'name' => 'required',
            'description' => 'required',
            'product_category' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'cost' => 'required',
        ]);

        try{

            DB::beginTransaction();
            //store to product 
            $product                        = new Product();
            $product->restaurant_id         = 1;
            $product->product_code          = $request->product_code;
            $product->name                  = $request->name;
            $product->discription           = $request->description;
            $product->product_category_id   = $request->product_category;
            $product->brand_id              = $request->brand;
            $product->supplier_id           = $request->supplier;
            $product->cost                  = $request->cost;
            $product->status                = $request->status;
            $product->created_by            = \Auth::user()->email;
            $product->save();
            
            //store to stock
            $stock = new Stock();
            $stock->product_id = $product->id;
            $stock->quantity = $request->quantity;
            if(Auth::user()->canDo('manage_admin')) {
                $stock->quantity = $request->quantity;
            } else if (Auth::user()->canDo('manage_store')) {
                $stock->quantity = 0;
            }
            $stock->unit_id = $request->unit;
            $stock->created_by = \Auth::user()->email;
            $stock->save();

            //add to product map
            $product_map = new Product_price();
            $product_map->product_id = $product->id;
            $product_map->quantity = $stock->quantity;
            $product_map->supplier_id = $request->supplier;
            $product_map->unit_id = $request->unit;
            $product_map->price = $product->cost;
            $product_map->total_price = $product->cost*$stock->quantity;
            if(Auth::user()->canDo('manage_admin')) {
                $product_map->status = 1;
            } else if (Auth::user()->canDo('manage_store')) {
                $product_map->status = 0;
            }
            $product_map->created_by = \Auth::user()->id;
            $product_map->save();

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('product.create'),  'message' => 'Raw Material store successfully'];
        }
        catch(\Throwable $e) {
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Raw Material'];
        }
    }

    public function requestProduct() 
    {
        if(!Auth::user()->canDo(['manage_admin', 'manage_store'])){
            abort(401, 'Unauthorized Error');
        }
        $products = Product::all();
        $price = Product_price::sum('total_price');
        $data = [
            'page_title' => 'Raw Material List',
            'page_header' => 'Raw Material List',
            'page_desc' => '',
            'products' => $products,
            'total_price' => $price    
        ];

        return view('products.new-request')->with(array_merge($this->data, $data));
    }

    public function cancelRequestProduct() 
    {
        if(!Auth::user()->canDo(['manage_admin', 'manage_store'])){
            abort(401, 'Unauthorized Error');
        }
        $products = Product::all();
        $price = Product_price::sum('total_price');
        $data = [
            'page_title' => 'Raw Material List',
            'page_header' => 'Raw Material List',
            'page_desc' => '',
            'products' => $products,
            'total_price' => $price    
        ];

        return view('products.cancel-request')->with(array_merge($this->data, $data));
    }

    public function requestApproveProduct(Request $request, $id)
    {
        $pprice = Product_price::find($id);
        $product_id = $pprice->product_id;
        $pprice->status = 1;
        $pprice->updated_by = Auth::user()->id;
        $pprice->save();
        $stock = Stock::where('product_id', $product_id)->first();
        $stock->quantity = $stock->quantity + $pprice->quantity;
        if($stock->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'message' => 'Successfully Approved'];
        }
        
    }

    public function requestCancelProduct(Request $request, $id)
    {
        $pprice = Product_price::find($id);
        $pprice->status = 2;
        $pprice->updated_by = Auth::user()->id;
        if($pprice->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'message' => 'Successfully Canceled'];
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        
        $data = [
            'page_title'  => 'Update Raw Materials',
            'page_header' => 'Update Raw Materials',
            'page_desc'   => '',
            'categories'  => ProductCategory::all(),
            'brands'  => Brand::all(),
            'suppliers'  => Supplier::all(),
            'units' => Unit::all(),
            'product' => $product
        ];

        return view('products.edit')->with(array_merge($this->data, $data));
    }

    //update product
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            //'product_code' => 'required|unique:products',
            'name' => 'required',
            'description' => 'required',
            'product_category' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'cost' => 'required',
        ]);

        try{

            DB::beginTransaction();
            //store to product 
            $product                        = Product::find($id);
            $product->restaurant_id         = 1;
            $product->product_code          = $request->product_code;
            $product->name                  = $request->name;
            $product->discription           = $request->description;
            $product->product_category_id   = $request->product_category;
            $product->brand_id              = $request->brand;
            $product->supplier_id           = $request->supplier;
            $product->cost                  = $request->cost;
            $product->status                = $request->status;
            $product->updated_by            = \Auth::user()->email;
            $product->save();
            
            //store to stock
            $stock = Stock::where('product_id', $id)->first();
            //product_price_map store
            if($stock->quantity < $request->quantity){
                $product_map = new Product_price();
                $product_map->product_id = $product->id;
                $product_map->quantity = $request->quantity - $stock->quantity;
                $product_map->unit_id = $request->unit;
                $product_map->price = $product->cost;
                $product_map->total_price = $product->cost*($request->quantity - $stock->quantity);
                $product_map->status = 0;
                if(Auth::user()->canDo('manage_admin')) {
                    $product_map->status = 1;
                } 
                else if (Auth::user()->canDo('manage_store')) {
                    $product_map->status = 0;
                }
                $product_map->created_by = \Auth::user()->id;
                $product_map->save();
            }
            if(Auth::user()->canDo('manage_admin')) {
                $stock->quantity = $request->quantity;
            } 
            else if (Auth::user()->canDo('manage_store')) {
                $stock->quantity = $stock->quantity;
            }
            $stock->unit_id = $request->unit;
            $stock->updated_by = \Auth::user()->email;
            $stock->save();

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('product.list'), 'message' => 'Product has been Updated Successfully'];
        }
        catch(\Throwable $e) {
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to udpate Product'];
        }
    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }   
        $product = Product::find($id);
        $product->deleted_by = \Auth::user()->email;
        $product->save();
        if ($product->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'The Product has been deleted successfully.'];
        }
    }

    //send product to kitchen form stock
    public function kitchenStore(Request $request)
    {
        $this->validate($request, [
            'product' => 'required',
            'quantity' => 'required'
        ]);

        try{
            DB::beginTransaction();

            $product = Product::find($request->product);
            if($product->stock->quantity < $request->quantity) {
                return ['type' => 'error', 'title' => 'Opps!', 'message' => 'There are not enough Quanity of products in the Stock'];
            }

            $stock = Stock::where('product_id', $request->product)->first();
            $stock->quantity = $stock->quantity - $request->quantity;
            $stock->save();
            //check the product on kitchen
            $check_product = Kitchen_stock::where('product_id', $request->product)->first();
            
            if($check_product) {
                $check_product->quantity = $check_product->quantity + $request->quantity;
                $check_product->updated_by = \Auth::user()->email;
                $check_product->save();
            }
            else {
                $kitchen = new Kitchen_stock();
                $kitchen->product_id = $request->product;
                $kitchen->quantity = $request->quantity;
                $kitchen->created_by = \Auth::user()->email;
                $kitchen->save();
            }
            //

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('product.list'), 'message' => 'Product has been sent to kithcen stock'];
        }
        catch(\Throwable $e) {
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong'];
        }
        
    }

    //send product to kitchen form stock
    public function wastedStore(Request $request)
    {
        $this->validate($request, [
            'product' => 'required',
            'quantity' => 'required'
        ]);

        try{
            DB::beginTransaction();

            $product = Product::find($request->product);
            if($product->stock->quantity < $request->quantity) {
                return ['type' => 'error', 'title' => 'Opps!', 'message' => 'There are not enough Quanity of products in the Stock'];
            }

            $stock = Stock::where('product_id', $request->product)->first();
            $stock->quantity = $stock->quantity - $request->quantity;
            $stock->save();
            //check the product on kitchen
            $check_product = Wasted_stock::where('product_id', $request->product)->first();
            
            if($check_product) {
                $check_product->quantity = $check_product->quantity + $request->quantity;
                $check_product->updated_by = \Auth::user()->email;
                $check_product->save();
            }
            else {
                $wasted = new Wasted_stock();
                $wasted->product_id = $request->product;
                $wasted->quantity = $request->quantity;
                $wasted->created_by = \Auth::user()->email;
                $wasted->save();
            }
            //

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('product.list'), 'message' => 'Product has been sent to kithcen stock'];
        }
        catch(\Throwable $e) {
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong'];
        }
        
    }

    //send product to kitchen form stock
    public function wastedFromKitchen(Request $request)
    {
        $this->validate($request, [
            'product' => 'required',
            'quantity' => 'required'
        ]);

        try{
            DB::beginTransaction();

            $product = Product::find($request->product);
            if($product->kitchen->quantity < $request->quantity) {
                return ['type' => 'error', 'title' => 'Opps!', 'message' => 'There are not enough Quanity of products in the Stock'];
            }

            $stock = Kitchen_stock::where('product_id', $request->product)->first();
            $stock->quantity = $stock->quantity - $request->quantity;
            $stock->save();
            //check the product on kitchen
            $check_product = Wasted_stock::where('product_id', $request->product)->first();
            
            if($check_product) {
                $check_product->quantity = $check_product->quantity + $request->quantity;
                $check_product->updated_by = \Auth::user()->email;
                $check_product->save();
            }
            else {
                $wasted = new Wasted_stock();
                $wasted->product_id = $request->product;
                $wasted->quantity = $request->quantity;
                $wasted->created_by = \Auth::user()->email;
                $wasted->save();
            }
            //

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('product.kitchen.stock'), 'message' => 'Product has been sent to kithcen stock'];
        }
        catch(\Throwable $e) {
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong'];
        }
        
    }


    //send product to kitchen form stock
    public function backStock(Request $request)
    {
        $this->validate($request, [
            'product' => 'required',
            'quantity' => 'required'
        ]);

        try{
            DB::beginTransaction();

            $product = Product::find($request->product);
            if($product->kitchen->quantity < $request->quantity) {
                return ['type' => 'error', 'title' => 'Opps!', 'message' => 'There are not enough Quanity of products in the Kitchen'];
            }

            $kitchen = Kitchen_stock::where('product_id', $request->product)->first();
            $kitchen->quantity = $kitchen->quantity - $request->quantity;
            $kitchen->save();

            //add quantity from kitchen to stock
            $stock = Stock::where('product_id', $request->product)->first();
            $stock->quantity = $stock->quantity + $request->quantity;
            $stock->updated_by = \Auth::user()->email;
            $stock->save();

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('product.kitchen.stock'), 'message' => 'Product has been added to stock from Kitchen'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong'];
        }
        
    }

    public function kitchenStock()
    {
        $products =  Product::all();
        $data = [
            'page_title' => 'Kitchen Stock',
            'page_header' => 'Kitchen Stock',
            'page_desc' => '',
            'products' => $products
        ];

        return view('products.kitchen.index')->with(array_merge($this->data, $data));
    }

    public function wastedStock()
    {
        $data = [
            'page_title' => 'Wasted Products',
            'page_header' => 'Wasted Products',
            'page_desc' => ''
        ];

        return view('products.wasted.index')->with(array_merge($this->data, $data));
    }


}
