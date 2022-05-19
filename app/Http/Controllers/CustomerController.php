<?php

namespace App\Http\Controllers;

use Auth;
use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = Customer::all();
        $data = [
            'page_title' => 'Customer :: Jannat Restaurant & Resort',
            'page_header' => 'Customer',
            'page_description' => ' ',
            'customers' => $customers
        ];

        return view('customer.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|unique:customers|max:14|min:11|regex:/\+?(88)?0?1[56789][0-9]{8}\b/',
            'email' => 'nullable|email|unique:customers,email'
        ]);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->status = $request->status;
        $customer->created_by = \Auth::user()->email;
        
        if($customer->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('customer') ,'message' => 'Menu Customer Stored Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Customer'];
    }

    //edit customer details
    public function edit(Request $request)
    {
        $data = Customer::find($request->customer_id);
        return $data;
    }

    //update customer detials
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'max:14|min:11|unique:customers,phone,'.$request->customer_id,
            'email' => 'nullable|email|unique:customers,email,'.$request->customer_id
        ]);

        $customer = Customer::find($request->customer_id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->status = $request->status;
        $customer->updated_by = \Auth::user()->email;

        if($customer->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('customer') ,'message' => 'Customer Updated Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to updated Customer'];
    }

    //delete Customer Details
    public function destroy($id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }

        $customer = Customer::find($id);
        $customer->deleted_by = \Auth::user()->email;
        $customer->save();

        if ($customer->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Customer Deleted Successfully!'];
        }
    }

    //get all customer
    public function getCustomer()
    {
        //$customers = Customer::all();
        return Datatables::of(Customer::all())
        ->addColumn('action', function ($customer) {
            return '<form action="" method="post">
            <input type="hidden" name="_token" id="csrf-token" value="'.Session::token().'" />
            <button type="button" name="edit_data" id="{{ $customer->id }}" class="btn btn-xs btn-primary edit_data"  data-toggle="modal" data-target="#edit_modal"><i class="fa fa-edit"></i></button>
            ';
        })
        ->make(true);
    }

}
