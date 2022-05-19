<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kitchen;
use App\KitchenChief;
use App\User;
use Auth;
class KitchenController extends Controller
{
    public function index()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Kitchen List :: Jannat Restaurant & Resort',
            'page_header' => 'Kitchen List',
            'page_desc' => '',
            'kitchens' => Kitchen::all(),
        ];

        return view('kitchen.index')->with(array_merge($this->data,$data));
    }
    //for store data
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:kitchens',
        ]);

        $kitchen = new Kitchen();
        $kitchen->restaurant_id = 1;
        $kitchen->name = $request->name;
        $kitchen->nick_name = $request->nickname;
        $kitchen->discription = $request->discription;
        $kitchen->created_by = \Auth::user()->email;
        if($kitchen->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('kitchen') ,'message' => 'Kitchen Created Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to create Kitchen'];

    }

    public function edit(Request $request)
    {
        $data =  Kitchen::find($request->kitchen_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:kitchens,name,'.$request->kitchen_id,

        ]);

        $kitchen = Kitchen::find($request->kitchen_id);
        $kitchen->name = $request->name;
        $kitchen->nick_name = $request->nickname;
        $kitchen->discription = $request->discription;
        $kitchen->updated_by = \Auth::user()->email;
        if($kitchen->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('kitchen') ,'message' => 'Kitchen Updated Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to updated Kitchen'];
    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $kitchen = Kitchen::find($id);
        $kitchen->deleted_by = \Auth::user()->email;
        $kitchen->save();
        if ($kitchen->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Kitchen has been deleted successfully.'];
        }
    }

    //for kitchen and chief

    public function kitchenchiefindex()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Kitchen & Chief List :: Jannat Restaurant & Resort',
            'page_header' => 'Kitchen & Chief List',
            'page_desc' => '',
            'kitchens' => Kitchen::all(),
            'users' => User::all(),
        ];

        return view('kitchen.kitchenandchief.index')->with(array_merge($this->data,$data));
    }

    //for store data
    public function kitchenchiefstore(Request $request)
    {
        $this->validate($request, [
            'kitchen' => 'required',
            'user_id' => 'required|unique:kitchen_chiefs',
        ]);

        $kitchenchief = new KitchenChief();
        $kitchenchief->kitchen_id = $request->kitchen;
        $kitchenchief->user_id = $request->user_id;
        $kitchenchief->created_by = \Auth::user()->email;
        if($kitchenchief->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('kitchenchief') ,'message' => 'Data Added Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Added Data'];

    }
    //for view
    public function kitchenchiefedit(Request $request)
    {
        $data =  KitchenChief::find($request->kitchenchief_id);

        return $data;
    }

    public function kitchenchiefupdate(Request $request)
    {
        $this->validate($request, [
            'kitchen' => 'required',
            'user_id' => 'required|unique:kitchen_chiefs,kitchen_id,'.$request->kitchenchief_id,

        ]);

        $kitchenchief = KitchenChief::find($request->kitchenchief_id);
        $kitchenchief->kitchen_id = $request->kitchen;
        $kitchenchief->user_id = $request->user_id;
        $kitchenchief->updated_by = \Auth::user()->email;
        if($kitchenchief->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('kitchenchief') ,'message' => 'Data Updated Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to updated Data'];
    }
    public function kitchenchiefdestroy(Request $request, $delid)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $kitchenchief = KitchenChief::find($delid);
        $kitchenchief->deleted_by = \Auth::user()->email;
        $kitchenchief->save();
        if ($kitchenchief->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }


}
