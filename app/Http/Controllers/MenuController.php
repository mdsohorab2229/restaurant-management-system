<?php

namespace App\Http\Controllers;

use App\Utility;
use Illuminate\Http\Request;
use App\Menu;
use App\Product;
use App\Kitchen;
use App\MenuCategory;
use App\Ingredient_mapping;
use App\Menu_menucategory_mapping;
use Illuminate\Support\Facades\DB;
use Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use Response;

class MenuController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Menu List :: Jannat Restaurant & Resort',
            'page_header' => 'Menu List',
            'page_desc' => '',
            'menus' => Menu::all(),
            'products' => Product::all(),
            'menucategories' =>MenuCategory::all(),
            'kitchens' =>Kitchen::all(),
        ];

        return view('menus.index')->with(array_merge($this->data,$data));
    }

    //store product
    public function store(Request $request)
    {

        $this->validate($request, [

            'name' => 'required',
            'cost' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'menu_category' => 'required',
            'product' => '',
            'kitchen' => 'required',
            'status' => 'required',
        ]);
        // upload photo
        if ($request->hasFile('menu_photo')) {
            $path = Utility::file_upload($request, 'menu_photo', 'Menu_Photo');
        } else {
            $path = null;
        }

        try{

            DB::beginTransaction();
            //make menu
            $menu                           = new Menu();
            $menu->restaurant_id            = 1;
            $menu->name                     = $request->name;
            $menu->nick_name                = $request->nick_name;
            $menu->discription              = $request->description;
            $menu->cost                     = $request->cost;
            $menu->price                    = $request->price;
            $menu->discount                 = $request->discount;
            $menu->discount_method          = $request->discount_type;
            $menu->kitchen_id               = $request->kitchen;
            $menu->availability             = $request->status;
            $path ? $menu->photo            = $path : null;
            $menu->created_by               = \Auth::user()->email;
            $menu->save();

            //menu to manucategory maping


            $menu_categories= $request->menu_category;

            if($menu_categories) {
                foreach ($menu_categories as $category_id) {
                    $menu_category = new Menu_menucategory_mapping();
                    $menu_category->menu_id = $menu->id;
                    $menu_category->menu_category_id = $category_id;
                    $menu_category->created_by = \Auth::user()->email;
                    $menu_category->save();
                }
            }

            //menu to manutoproduct maping

            $menu_products = $request->product;
            if($menu_products) {
                foreach ($menu_products as $product_id) {
                    $menutoproduct = new Ingredient_mapping();
                    $menutoproduct->menu_id = $menu->id;
                    $menutoproduct->product_id = $product_id;
                    $menutoproduct->created_by = \Auth::user()->email;
                    $menutoproduct->save();
                }
            }

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('menu'), 'message' => 'Menu store successfully'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Product'];
        }
    }

    //delete menu
    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $menu = Menu::find($id);
        $menu->deleted_by = \Auth::user()->email;
        $menu->save();
        if ($menu->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Menu has been deleted successfully.'];
        }
    }

    //view menu
    public function view(Request $request)
    {
        $menu = Menu::find($request->menu_id);
        $Menu_category=Menu_menucategory_mapping::with('menuCategory')->where('menu_id',$request->menu_id)->get();
        $product=Ingredient_mapping::with('product')->where('menu_id',$request->menu_id)->get();

        $data = [
            'categories' => $Menu_category,
            'products'   => $product,
            'menus'       => $menu,
            'menus'       => $menu,

        ];

        return $data;


    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        $Menu_category=Menu_menucategory_mapping::with('menuCategory')->where('menu_id',$id)->get()->pluck('menu_category_id')->toArray();
        $product=Ingredient_mapping::with('product')->where('menu_id',$id)->get()->pluck('product_id')->toArray();

        $data = [
            'page_title' => 'Edit Menu',
            'page_header' => 'Edit Menu',
            'page_desc' => '',
            'menucategories' => MenuCategory::all(),
            'menu_products' => Product::all(),
            'categories' => $Menu_category,
            'products'   => $product,
            'menu'       => $menu,
            'kitchens' =>Kitchen::all(),

        ];

        return view('menus.edit')->with(array_merge($this->data, $data));
    }

    //update menu
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'cost' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'kitchen' => 'required',
            'status' => 'required',

        ]);
        // upload photo
        if ($request->hasFile('menu_photo')) {
            $path = Utility::file_upload($request, 'menu_photo', 'Menu_Photo');
        } else {
            $path = $request->hidden_image_path ? $request->hidden_image_path : "";
        }

        try{

            DB::beginTransaction();
            //make menu
            $menu                           = Menu::find($id);
            $menu->name                     = $request->name;
            $menu->nick_name                = $request->nick_name;
            $menu->discription              = $request->description;
            $menu->cost                     = $request->cost;
            $menu->price                    = $request->price;
            $menu->discount                 = $request->discount;
            $menu->discount_method          = $request->discount_type;
            $menu->kitchen_id               = $request->kitchen;
            $menu->availability             = $request->status;
            $path ? $menu->photo            = $path : null;
            $menu->updated_by               = \Auth::user()->email;
            $menu->save();
            //menu to manucategory maping

            //previous category Delete
            Menu_menucategory_mapping::where('menu_id', $id)->delete();

            $menu_categories= $request->menu_category;

            if($menu_categories) {
                foreach ($menu_categories as $category_id) {
                    $menu_category = new Menu_menucategory_mapping();
                    $menu_category->menu_id = $menu->id;
                    $menu_category->menu_category_id = $category_id;
                    $menu_category->created_by = \Auth::user()->email;
                    $menu_category->save();
                }
            }

            //menu to manutoproduct maping
            Ingredient_mapping::where('menu_id', $id)->delete();

            $menu_products = $request->product;

            if($menu_products) {
                foreach ($menu_products as $product_id) {
                    $menutoproduct = new Ingredient_mapping();
                    $menutoproduct->menu_id = $menu->id;
                    $menutoproduct->product_id = $product_id;
                    $menutoproduct->created_by = \Auth::user()->email;
                    $menutoproduct->save();
                }
            }

            DB::commit();

            return ['type' => 'success', 'title' => 'Updated!', 'redirect' => route('menu'), 'message' => 'Menu store successfully'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Product'];
        }
    }



}
