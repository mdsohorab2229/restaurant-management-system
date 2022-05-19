<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use App\Expense;
use Illuminate\Http\Request;
use Auth;
use DB;


class ExpenseController extends Controller
{
    //
    public function index()
    {
        $categories = ExpenseCategory::all();
        $total_expense = Expense::sum('amount');
        $data = [
            'page_title' => 'Expenses',
            'page_header' => 'Expenses',
            'page_desc' => '',
            'categories' => $categories,
            'total_expense' => $total_expense
        ];

        return view('expense.index')->with(array_merge($this->data, $data));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' =>'required'
            
        ]);

        $expense = new Expense();
        $expense->expense_category_id = $request->expense_category;
        $expense->title = $request->title;
        $expense->description = $request->description;
        $expense->amount = $request->amount;
        $expense->expense_date = $request->expense_date;
        $expense->created_by = \Auth::user()->email;
        
        if($expense->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('expense.list') ,'message' => 'Expense has been saved Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Customer'];
    }

    public function edit(Request $request)
    {
        $data =  Expense::find($request->expense_id);

        return $data;
    }

    //for update

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' =>'required'
        ]);

        $expense = Expense::find($request->expense_id);
        $expense->expense_category_id = $request->expense_category;
        $expense->title = $request->title;
        $expense->description = $request->description;
        $expense->amount = $request->amount;
        $expense->expense_date = $request->expense_date;
        $expense->updated_by = \Auth::user()->email;
        if($expense->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('expense.list') ,'message' => 'Expense Stored Successfully'];
        }
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Expense Successfully'];

    }

    public function destroy(Request $request, $id)
    {
        if(!Auth::user()->canDo('manage_admin')){
            abort(401, 'Unauthorized Error');
        }
        $expense = Expense::find($id);
        $expense->deleted_by = \Auth::user()->email;
        $expense->save();
        if ($expense->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Expanse has been deleted successfully.'];
        }
    }

    public function reportsearch(Request $request)
    {
        if ($request->from_date || $request->to_date || $request->expense_category) {
            if ($request->expense_category) {
                $expenses = Expense::where(DB::raw('expense_category_id'), $request->expense_category)->orderBy('id', 'DESC')->get();

            }
            if ($request->from_date) {
                $expenses = Expense::where(DB::raw('date(expense_date)'), $request->from_date)->orderBy('id', 'DESC')->get();

            }
            if ($request->from_date && $request->to_date) {
                $expenses = Expense::whereBetween(DB::raw('date(expense_date)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->get();

            }
            if ($request->from_date && $request->to_date && $request->expense_category) {
                $expenses = Expense::where('expense_category_id',$request->expense_category)->whereBetween(DB::raw('date(expense_date)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->get();

            }
            if ($request->expense_category) {
                $ts = Expense::where(DB::raw('expense_category_id'), $request->expense_category)->orderBy('id', 'DESC')->groupBy('expense_category_id')
                    ->selectRaw('sum(amount) as sum, expense_category_id')
                    ->get();

            }
            if ($request->from_date) {
                $ts = Expense::where(DB::raw('date(expense_date)'), $request->from_date)->orderBy('id', 'DESC')->groupBy('expense_category_id')
                    ->selectRaw('sum(amount) as sum, expense_category_id')
                    ->get();

            }
            if ($request->from_date && $request->to_date) {
                $ts = Expense::whereBetween(DB::raw('date(expense_date)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->groupBy('expense_category_id')
                    ->selectRaw('sum(amount) as sum, expense_category_id')
                    ->get();

            }
            if ($request->from_date && $request->to_date && $request->expense_category) {
                $ts = Expense::where('expense_category_id',$request->expense_category)->whereBetween(DB::raw('date(expense_date)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->groupBy('expense_category_id')
                    ->selectRaw('sum(amount) as sum, expense_category_id')
                    ->get();

            }

            $data = [
                'page_title' => 'Expense Report',
                'page_header' => 'Expense Report',
                'page_desc' => '',
                'categories' => ExpenseCategory::all(),
                'expenses' => $expenses,
                'expcategory' => $request->expense_category,
                'form_date' => $request->from_date,
                'to_date' => $request->to_date,
                'ts'       =>$ts,
            ];

            return view('expense.search-expense')->with(array_merge($this->data, $data));
        }
    }
}
