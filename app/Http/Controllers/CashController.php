<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cash;
use Auth;
use App\User;
use App\CashCashier;

class CashController extends Controller
{
    public function index()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Cash List :: Jannat Restaurant & Resort',
            'page_header' => 'Cash List',
            'page_desc' => '',
            'cashes' => Cash::all(),
        ];

        return view('cash.index')->with(array_merge($this->data,$data));
    }

    //for store data
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:cashes',
        ]);

        $cash = new Cash();
        $cash->restaurant_id = 1;
        $cash->name = $request->name;
        $cash->nick_name = $request->nickname;
        $cash->discription = $request->discription;
        $cash->created_by = \Auth::user()->email;
        if($cash->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('cash') ,'message' => 'Cash Created Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to create Cash'];

    }

    public function edit(Request $request)
    {
        $data =  Cash::find($request->cash_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:cashes,name,'.$request->cash_id,

        ]);

        $cash = Cash::find($request->cash_id);
        $cash->name = $request->name;
        $cash->nick_name = $request->nickname;
        $cash->discription = $request->discription;
        $cash->updated_by = \Auth::user()->email;
        if($cash->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('cash') ,'message' => 'Cash Updated Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to updated Cash'];
    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $cash = Cash::find($id);
        $cash->deleted_by = \Auth::user()->email;
        $cash->save();
        if ($cash->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Cash has been deleted successfully.'];
        }
    }

    //for Cashier and cash

    public function cashcashierindex()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Cash & Cashier List :: Jannat Restaurant & Resort',
            'page_header' => 'Cash & Cashier List',
            'page_desc' => '',
            'cashes' => Cash::all(),
            'users' => User::all(),
        ];

        return view('cash.cashcashier.index')->with(array_merge($this->data,$data));
    }

    //for store data
    public function cashcashierstore(Request $request)
    {
        $this->validate($request, [
            'cash' => 'required',
            'user_id' => 'required|unique:cash_cashiers',
        ]);

        $cashcashier = new CashCashier();
        $cashcashier->cash_id = $request->cash;
        $cashcashier->user_id = $request->user_id;
        $cashcashier->created_by = \Auth::user()->email;
        if($cashcashier->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('cashcashier') ,'message' => 'Data Added Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Added Data'];

    }

    //for view
    public function editcashcashier(Request $request)
    {
        $data =  CashCashier::find($request->cashcashier_id);

        return $data;
    }

    public function updatecashcashier(Request $request)
    {
        $this->validate($request, [
            'cash' => 'required',
            'user_id' => 'required|unique:cash_cashiers,cash_id,'.$request->cashcashier_id,

        ]);

        $cashcashier = CashCashier::find($request->cashcashier_id);
        $cashcashier->cash_id = $request->cash;
        $cashcashier->user_id = $request->user_id;
        $cashcashier->updated_by = \Auth::user()->email;
        if($cashcashier->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('cashcashier') ,'message' => 'Data Updated Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to updated Data'];
    }


    public function cashcashierdestroy(Request $request, $delid)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $cashcashier = CashCashier::find($delid);
        $cashcashier->deleted_by = \Auth::user()->email;
        $cashcashier->save();
        if ($cashcashier->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }


}
