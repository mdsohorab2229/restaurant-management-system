<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banklist;
use App\Bankloan;
use Auth;
use DB;
class BankloanController extends Controller
{
    public function index()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Bank Loan List :: Jannat Restaurant & Resort',
            'page_header' => 'Bank Loan List',
            'page_desc' => '',
            'banklists' => Banklist::all(),
            'deposit'   => Bankloan::where('loan_type','loan_deposite')->get()->sum('amount'),
            'interest'   => Bankloan::where('loan_type','loan_deposite')->get()->sum('interest'),
            'withdraw'   => Bankloan::where('loan_type','loan_withdraw')->get()->sum('amount'),

        ];

        return view('banks.loan.index')->with(array_merge($this->data,$data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'bank_name' => 'required',
            'loan_term' => 'required',
            'category' => 'required',
            'loan_duration' => 'required',
            'amount' => 'required',
            'interest' => 'required',
            'submited_date' => 'required',
            'category' => 'required',
            'amount' => 'required',
            'status' => 'required',

        ]);

        if('loan_deposite' == $request->category) {
            $deposit = Bankloan::where('banklist_id', $request->bank_name)->where('loan_type', 'loan_deposite')->get()->sum('amount');
            $withdraw = Bankloan::where('banklist_id', $request->bank_name)->where('loan_type', 'loan_withdraw')->get()->sum('amount');
            $balance = $withdraw - $deposit;
            if($balance < $request->amount) {
                return ['type' => 'error', 'title' => 'Loan withdraw not found!', 'message' => 'No Withdraw loan found'];
            }

        }

        $bankloan = new Bankloan();
        $bankloan->banklist_id = $request->bank_name;
        $bankloan->loan_term = $request->loan_term;
        $bankloan->loan_type = $request->category;
        $bankloan->loan_duration = $request->loan_duration;
        $bankloan->amount = $request->amount;
        $bankloan->interest = $request->interest;
        $bankloan->submit_date = $request->submited_date;
        $bankloan->description = $request->description;
        $bankloan->status = $request->status;
        $bankloan->created_by = \Auth::user()->email;
        if($bankloan->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('bankloan') ,'message' => 'Data Stored Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Data Successfully'];
    }

    public function edit(Request $request)
    {
        $data =  Bankloan::find($request->bankloan_id);

        return $data;
    }

    public function update(Request $request)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $this->validate($request, [
            'bank_name' => 'required',
            'loan_term' => 'required',
            'category' => 'required',
            'loan_duration' => 'required',
            'amount' => 'required',
            'interest' => 'required',
            'submited_date' => 'required',
            'category' => 'required',
            'amount' => 'required',
            'status' => 'required',

        ]);
        $bankloan = Bankloan::find($request->bankloan_id);
        $bankloan->banklist_id = $request->bank_name;
        $bankloan->loan_term = $request->loan_term;
        $bankloan->loan_type = $request->category;
        $bankloan->loan_duration = $request->loan_duration;
        $bankloan->amount = $request->amount;
        $bankloan->interest = $request->interest;
        $bankloan->submit_date = $request->submited_date;
        $bankloan->description = $request->description;
        $bankloan->status = $request->status;
        $bankloan->updated_by = \Auth::user()->email;
        if($bankloan->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('bankloan') ,'message' => 'Data Updated Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Updated Data Successfully'];

    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $bankloan = Bankloan::find($id);
        $bankloan->deleted_by = \Auth::user()->email;
        $bankloan->save();
        if ($bankloan->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }
}
