<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Bankmoney;
use App\Banklist;
use DB;

class BankMoneyController extends Controller
{
    public function index()
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $data = [
            'page_title' => 'Bank Money List :: Jannat Restaurant & Resort',
            'page_header' => 'Bank Money List',
            'page_desc' => '',
            'bankmoneys' => Bankmoney::all(),
            'banklists' => Banklist::all(),
            'deposite'      =>  Bankmoney::orderBy('id', 'DESC')
                ->where('type', 'deposite')
                ->get()->sum('Amount'),
            'withdraw'    =>  Bankmoney::orderBy('id', 'DESC')
                ->where('type', 'withdraw')
                ->get()->sum('Amount')
        ];

        return view('banks.index')->with(array_merge($this->data,$data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'bank_name' => 'required',
            'submited_date' => 'required',
            'category' => 'required',
            'amount' => 'required',
            'status' => 'required',

        ]);

        if('withdraw' == $request->category) {

            $deposit = Bankmoney::where('banklist_id', $request->bank_name)->where('type', 'deposite')->get()->sum('Amount');
            $withdraw = Bankmoney::where('banklist_id', $request->bank_name)->where('type', 'withdraw')->get()->sum('Amount');
            $balance = $deposit - $withdraw;
            if($balance < $request->amount) {
                return ['type' => 'error', 'title' => 'Balance Insufficient!', 'message' => 'Insufficient Balance at the following Bank'];
            }

        }

        $bankmoney = new Bankmoney();
        $bankmoney->banklist_id = $request->bank_name;
        $bankmoney->type = $request->category;
        $bankmoney->Amount = $request->amount;
        $bankmoney->submit_date = $request->submited_date;
        $bankmoney->description = $request->description;
        $bankmoney->status = $request->status;
        $bankmoney->created_by = \Auth::user()->email;
        if($bankmoney->save())
        {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('bankmoney') ,'message' => 'Data Stored Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Data Successfully'];
    }

    public function edit(Request $request)
    {
        $data =  Bankmoney::find($request->bankmoney_id);

        return $data;
    }

    public function update(Request $request)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $this->validate($request, [
            'bank_name' => 'required',
            'category' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);

        $bankmoney = Bankmoney::find($request->bankmoney_id);
        $bankmoney->banklist_id = $request->bank_name;
        $bankmoney->type = $request->category;
        $bankmoney->Amount = $request->amount;
        $bankmoney->submit_date = $request->submited_date;
        $bankmoney->description = $request->description;
        $bankmoney->status = $request->status;
        $bankmoney->updated_by = \Auth::user()->email;
        if($bankmoney->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('bankmoney') ,'message' => 'Data Updated Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Updated Data Successfully'];

    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $bankmoney = Bankmoney::find($id);
        $bankmoney->deleted_by = \Auth::user()->email;
        $bankmoney->save();
        if ($bankmoney->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Data has been deleted successfully.'];
        }
    }


    public function filter(Request $request) {
        $this->validate($request, [
            'bank_list' => 'required'
        ]);

        $bankmoneies = Bankmoney::orderBy('submit_date', 'ASC');

        if($request->bank_list) {
            $bankmoneies = $bankmoneies->where('banklist_id', $request->bank_list);
        }

        if($request->type) {
            $bankmoneies = $bankmoneies->where('type', $request->type);
        }

        if($request->from_date && null == $request->to_date) {
            $bankmoneies = $bankmoneies->whereDate('submit_date', database_formatted_date($request->from_date));
        }

        if($request->to_date && null == $request->from_date) {
            $bankmoneies = $bankmoneies->whereDate('submit_date', database_formatted_date($request->to_date));
        }

        if($request->to_date && $request->from_date) {
            $bankmoneies = $bankmoneies->whereBetween('submit_date', [database_formatted_date($request->from_date), database_formatted_date($request->to_date)]);
        }

        //$banks = $bankmoneies->groupBy('banklist_id')->get();


        $bankmoneies = $bankmoneies->get();

        $data = [
            'page_title' => 'Bank Money Report',
            'page_header' => 'Bank Money Report',
            'page_desc' => '',
            'bankmoneys' => Bankmoney::all(),
            'banks' => Banklist::all(),
            'bankmoneies' => $bankmoneies,
            'bankname' => Banklist::where('id', $request->bank_list)->first()->name,
            'total' => 0
        ];

        return view('banks.filter-bankmoney')->with(array_merge($this->data, $data));
    }
}
