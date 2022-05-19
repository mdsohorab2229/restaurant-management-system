<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use App\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Investor Capital Amount List :: Jannat Restaurant & Resort',
            'page_header' => 'Capital Amount List',
            'page_desc' => '',
            'investments' => Investment::all(),
            'totalinvestments' => Investment::selectRaw('amount')->get()->sum('amount')

        ];

        return view('investments.index')->with(array_merge($this->data,$data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'amount' => 'required',
            'purpose' => 'required',
            'submited_date' => 'required',
            'status' => 'required',

        ]);
        $investment = new Investment();
        $investment->investor_name = $request->name;
        $investment->amount = $request->amount;
        $investment->purpose = $request->purpose;
        $investment->submit_date = $request->submited_date;
        $investment->description = $request->description;
        $investment->status = $request->status;
        $investment->created_by = \Auth::user()->email;
        if($investment->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('investment') ,'message' => 'Data Stored Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Data Successfully'];
    }

    public function edit(Request $request)
    {
        $data =  Investment::find($request->investment_id);

        return $data;
    }

    public function update(Request $request)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $this->validate($request, [
            'name' => 'required',
            'amount' => 'required',
            'purpose' => 'required',
            'submited_date' => 'required',
            'status' => 'required',
        ]);

        $investment = Investment::find($request->investment_id);
        $investment->investor_name = $request->name;
        $investment->amount = $request->amount;
        $investment->purpose = $request->purpose;
        $investment->submit_date = $request->submited_date;
        $investment->description = $request->description;
        $investment->status = $request->status;
        $investment->updated_by = \Auth::user()->email;
        if($investment->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('investment') ,'message' => 'Data Updated Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Updated Data Successfully'];

    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $investment = Investment::find($id);
        $investment->deleted_by = \Auth::user()->email;
        $investment->save();
        if ($investment->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }
}
