<?php

namespace App\Http\Controllers;

use Auth;
use App\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    //expcat = expense category

    public function index()
    {
        $data = [
            'page_title' => 'Expense Category List :: Jannat Restaurant & Resort',
            'page_header' => 'Expense Categories',
            'page_desc' => '',
            'expense_categories' => ExpenseCategory::all()
        ];

        return view('expensecategory.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:expense_categories'
        ]);

        $expcat = new ExpenseCategory();
        $expcat->name = $request->name;
        $expcat->created_by = \Auth::user()->email;
        if($expcat->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('expense-category') ,'message' => 'Expense Category Stored Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Expense Category Successfully'];

    }
    public function edit(Request $request)
    {
        $data =  ExpenseCategory::find($request->category_id);

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:expense_categories,name,'.$request->category_id
        ]);

        $expcat = ExpenseCategory::find($request->category_id);
        $expcat->name = $request->name;
        $expcat->updated_by = \Auth::user()->email;
        if($expcat->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('expense-category') ,'message' => 'Expense Category Updated Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Update Expense Category Successfully'];
    }

    public function destroy($id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $expcat = ExpenseCategory::find($id);
        $expcat->deleted_by = \Auth::user()->email;
        $expcat->save();
        if ($expcat->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'The Expense Category Deleted Successfully.'];
        }
    }
}
