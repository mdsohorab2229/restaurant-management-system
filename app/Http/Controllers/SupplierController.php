<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use Auth;
use App\Utility;
use App\Supplier_ladger;
class SupplierController extends Controller
{
    //view all suppliers
    public function index()
    {
        $suppliers = Supplier::all();
        $data = [
            'page_title' => 'Supplier :: Jannat Restaurant & Resort',
            'page_header' => 'Supplier',
            'page_description' => '',
            'suppliers' => $suppliers
        ];

        return view('supplier.index')->with(array_merge($this->data, $data));
    }

    //add all supplier
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|unique:suppliers|max:14|min:11|regex:/\+?(88)?0?1[3456789][0-9]{8}\b/',
            'email' => 'nullable|email|unique:suppliers,email'
        ]);

        $supplier = new Supplier();
        $supplier->restaurant_id = 1;
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->status = $request->status;
        $supplier->created_by = \Auth::user()->email;
        if($supplier->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('supplier') ,'message' => 'Menu Customer Stored Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Customer'];
    }

    //view for Edit
    public function edit(Request $request)
    {
        $data = Supplier::find($request->supplier_id);
        return $data;
    }


    //Update Supplier
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'max:14|min:11|regex:/\+?(88)?0?1[3456789][0-9]{8}\b/|unique:suppliers,phone,'.$request->supplier_id,
            'email' => 'nullable|email|unique:suppliers,email,'.$request->supplier_id
            
        ]);

        $supplier = Supplier::find($request->supplier_id);
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->status = $request->status;
        $supplier->updated_by = \Auth::user()->email;

        if($supplier->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('supplier') ,'message' => 'Supplier Updated Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to updated Supplier'];
    }
    
    //Delete Supplier
    public function destroy($id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }

        $supplier = Supplier::find($id);
        $supplier->deleted_by = \Auth::user()->email;
        $supplier->save();

        if ($supplier->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Supplier Deleted Successfully!'];
        }
    }


    //ledger for supplier
    public function supplierLedger()
    {
        $ledgers = Supplier_ladger::all();
        $total_amount = Supplier_ladger::sum('amount');
        $total_paid = Supplier_ladger::sum('paid_amount');
        $total_due = Supplier_ladger::sum('due');
        $data = [
            'page_title' => 'Supplier Ledgers',
            'page_header' => 'Supplier Ledgers',
            'page_desc' => '',
            'ledgers' => $ledgers,
            'suppliers' => Supplier::where('status', 1)->get(),
            'amount' => $total_amount, 
            'paid_amount' => $total_paid, 
            'due' => $total_due
        ];

        return view('ladger.supplier')->with(array_merge($this->data, $data));
    }

    public function supplierLedgerStore(Request $request)
    {
        $this->validate($request, [
            'supplier' => 'required',
            'amount' => 'required',
        ]);

        // upload photo
        if ($request->hasFile('file')) {
            $path = Utility::file_upload($request, 'file', 'supplier_ledger');
        } else {
            $path = null;
        }

        $sl = new Supplier_ladger();
        $sl->supplier_id = $request->supplier;
        $sl->description = $request->description;
        $sl->date = database_formatted_date($request->date);
        $sl->amount = $request->amount;
        $sl->paid_amount = $request->paid_amount;
        $sl->due = $request->amount - $request->paid_amount;
        $sl->created_by = Auth::user()->email;
        $sl->file = $path;

        if($sl->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('supplier.ledger') ,'message' => 'Saved Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong'];
    }

    public function supplierLedgerEdit(Request $request)
    {
        $ledger = Supplier_ladger::find($request->sledger_id);
        return $ledger;
    }

    public function supplierLedgerUpdate(Request $request)
    {
        $this->validate($request, [
            'supplier' => 'required',
            'amount' => 'required',
        ]);

        // upload photo
        if ($request->hasFile('file')) {
            $path = Utility::file_upload($request, 'file', 'supplier_ledger');
        } else {
            $path = null;
        }

        $sl = Supplier_ladger::find($request->ledger_id);
        $sl->supplier_id = $request->supplier;
        $sl->description = $request->description;
        $sl->date = database_formatted_date($request->date);
        $sl->amount = $request->amount;
        $sl->paid_amount = $request->paid_amount;
        $sl->due = $request->amount - $request->paid_amount;
        $sl->updated_by = Auth::user()->email;
        $path ? $sl->file = $path : $path=0;

        if($sl->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('supplier.ledger') ,'message' => 'Update Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong'];
    }

    public function supplierLedgerDestroy($id) 
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }

        $ledger = Supplier_ladger::find($id);
        $ledger->deleted_by = \Auth::user()->email;
        $ledger->save();

        if ($ledger->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Ladger Deleted Successfully!'];
        }
    }

}
