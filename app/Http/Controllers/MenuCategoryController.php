<?php


namespace App\Http\Controllers;

use Auth;
use App\MenuCategory;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    //
    public function index()
    {
        $data = [
            'page_title' => 'Menu Category List :: Jannat Restaurant & Resort',
            'page_header' => 'Menu Categories',
            'page_desc' => '',
            'menu_categories' => MenuCategory::all()
        ];

        return view('menucategories.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:menu_categories'
        ]);

        $mcat = new MenuCategory();
        $mcat->name = $request->name;
        $mcat->created_by = \Auth::user()->email;
        if($mcat->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('menu.categories') ,'message' => 'Menu Category Stored Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Menu Category Successfully'];

    }
    public function edit(Request $request)
    {
        $data =  MenuCategory::find($request->category_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:menu_categories,name,'.$request->category_id
        ]);

        $mcat = MenuCategory::find($request->category_id);
        $mcat->name = $request->name;
        $mcat->updated_by = \Auth::user()->email;
        if($mcat->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('menu.categories') ,'message' => 'Menu Category Updated Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Update Menu Category Successfully'];
    }

    public function destroy($id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $menu_category = MenuCategory::find($id);
        $menu_category->deleted_by = \Auth::user()->email;
        $menu_category->save();
        if ($menu_category->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'The Menu Item Category Deleted Successfully.'];
        }
    }
}
