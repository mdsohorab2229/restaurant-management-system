<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Billing;
use App\CustomerDue;
use Auth;
class LadgerController extends Controller
{
    //
    public function customer()
    {
        $billings = Billing::where('due', '>', 0)
        ->groupBy('customer_id')
        ->selectRaw('id')
        ->selectRaw('sum(due) as total_due')
        ->selectRaw('customer_id')
        ->paginate(20);
        $total_due = Billing::sum('due');
        $total_paid = CustomerDue::sum('paid');        
        
        $data = [
            'page_title' => 'Customer Ladger',
            'page_header' => 'Customer Ladger',
            'page_desc' => '',
            'billings' => $billings,
            'total_due' => $total_due,
            'total_paid' => $total_paid
        ];

        return view('ladger.customer-due')->with(array_merge($this->data, $data));
    }

    public function customerDue(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $due = Billing::where('customer_id', $customer->id)->sum('due');
        $total_paid = CustomerDue::where('customer_id', $customer->id)->sum('paid');
        $total_due = $due - $total_paid;
        $data = [
            'name' => $customer->name,
            'total_due' => $total_due
        ];
        return $data;
        
    }
    

    public function customerDueTaken(Request $request)
    {
        $id = $request->customer_id;
        $this->validate($request, [
            'paid_amount' => 'required'
        ]);

        $c_due = new CustomerDue();
        $c_due->customer_id = $id;
        $c_due->paid = $request->paid_amount;
        $c_due->paid_date = database_formatted_date($request->date);
        $c_due->created_by = Auth::user()->email;
        if($c_due->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('customer-ledger') ,'message' => 'Paid amount saved successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong'];
    }

    public function singleCustomerDue($id)
    {
        $billings = Billing::where('due', '>', 0)
        ->where('customer_id', $id)
        ->paginate(20);
        $total_due = Billing::where('customer_id', $id)->sum('due');
        $total_paid = CustomerDue::where('customer_id', $id)->sum('paid');

        $data = [
            'page_title' => 'Customer Ladger',
            'page_header' => 'Customer Ladger',
            'page_desc' => '',
            'billings' => $billings,
            'total_due' => $total_due,
            'total_paid' => $total_paid,
            'customer' => Customer::find($id)
        ];

        return view('ladger.single-customer-due')->with(array_merge($this->data, $data));
    }

}
