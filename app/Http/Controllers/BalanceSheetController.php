<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Setting;
use App\Asset;
use App\Bankmoney;
use App\Product;
use App\Billing;
use App\Expense;
use App\Wasted_stock;
use App\Kitchen_stock;
use App\Supplier_ladger;
use App\Investment;
use App\Bankloan;
use Carbon\Carbon;

class BalanceSheetController extends Controller
{
    public function index()
    {
        if (!Auth::user()->canDo('manage_admin')) {
            abort(401, 'Unauthorized Error');
        }
        $currentDateTime = Carbon::now()->format('l-M-Y');
        //from income statement for cash and last inventory
        $totalwasted = Wasted_stock::whereYear('created_at', Carbon::now()->year)->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier', 'product.stock', 'product.stock.unit'])
            ->get();
        $totalkitchenstock = Kitchen_stock::whereYear('created_at', Carbon::now()->year)->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier', 'product.stock', 'product.stock.unit'])
            ->get();

        $monthlyexpanse = Expense::whereYear('created_at', Carbon::now()->year)->orderBy('id', 'DESC')->groupBy('expense_category_id')
            ->selectRaw('sum(amount) as sum, expense_category_id')
            ->get();
        $monthlyexpansesumation = Expense::whereYear('created_at', Carbon::now()->year)->orderBy('id', 'DESC')->get();

        $products = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->whereYear('created_at', Carbon::now()->year)->get();
        $lastmonthproducts = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->whereYear('created_at', Carbon::now()->subYear()->year)->get();
        $sell = Billing::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->sum('deposit');

        //for suppliear due
        $total_supplier_due = Supplier_ladger::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->sum('due');

        //for customer due
        $total_customer_due = Billing::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->sum('due');

        $data = [
            'page_title' => 'Balance Sheet :: Jannat Restaurant & Resort',
            'page_header' => 'Balance Sheet',
            'page_desc' => '',
            'assets' => Asset::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->select(DB::raw('sum(price) as total'))
                ->groupBy(DB::raw('(assetcategory_id)'))
                ->selectRaw('assetcategory_id')
                ->get(),
            'totalassets' => Asset::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->selectRaw('assetcategory_id')->sum('price'),
            'deposite' => Bankmoney::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->orderBy('id', 'DESC')
                ->where('type', 'deposite')
                ->get()->sum('Amount'),
            'withdraw' => Bankmoney::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->orderBy('id', 'DESC')
                ->where('type', 'withdraw')
                ->get()->sum('Amount'),
            //for cash from income statement
            'products' => $products,
            'lastmonthproducts' => $lastmonthproducts,
            'sells' => $sell,
            'expenses' => $monthlyexpanse,
            'monthlyexpansesumation' => $monthlyexpansesumation,
            'totalwasted' => $totalwasted,
            'totalkitchenstock' => $totalkitchenstock,
            'total_supplier_dues' => $total_supplier_due,
            'total_customer_dues' => $total_customer_due,
            'total_account_receivables' => $total_supplier_due + $total_customer_due,
            'total_investments' => Investment::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->sum('amount'),
            //bankloan
            'deposit' => Bankloan::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->where('loan_term', 'short')->where('loan_type', 'loan_deposite')->get()->sum('amount'),
            'deposit_long' => Bankloan::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->where('loan_term', 'long')->where('loan_type', 'loan_deposite')->get()->sum('amount'),
            'deposit_interest_short' => Bankloan::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->where('loan_term', 'short')->where('loan_type', 'loan_deposite')->get()->sum('interest'),
            'deposit_interest_long' => Bankloan::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->where('loan_term', 'long')->where('loan_type', 'loan_deposite')->get()->sum('interest'),
            'withdraw_long' => Bankloan::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->where('loan_term', 'long')->where('loan_type', 'loan_withdraw')->get()->sum('amount'),
            'withdraw_short' => Bankloan::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->where('loan_term', 'short')->where('loan_type', 'loan_withdraw')->get()->sum('amount'),
            'withdraw_interest_long' => Bankloan::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->where('loan_term', 'long')->where('loan_type', 'loan_withdraw')->get()->sum('interest'),
            'withdraw_interest_short' => Bankloan::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->where('loan_term', 'short')->where('loan_type', 'loan_withdraw')->get()->sum('interest'),
            'currentDateTime' => $currentDateTime,

        ];


        return view('balancesheet.index')->with(array_merge($this->data, $data));
    }

    public function filter(Request $request)
    {
//        return "Sorry to Say That This page work is Processing please Wait....... <a href=\"javascript:history.back()\" class=\"btn btn-default\">Back</a>";
//        return view('balancesheet.balancesheet-filter');

        if ($request->from_date || $request->to_date) {
            if ($request->from_date) {
                //from income statement for cash and last inventory
                $totalwasted = Wasted_stock::where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier', 'product.stock', 'product.stock.unit'])
                    ->get();
                $totalkitchenstock = Kitchen_stock::where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier', 'product.stock', 'product.stock.unit'])
                    ->get();

                $monthlyexpanse = Expense::where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')->groupBy('expense_category_id')
                    ->selectRaw('sum(amount) as sum, expense_category_id')
                    ->get();
                $monthlyexpansesumation = Expense::where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')->get();

                $products = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->where(DB::raw('date(created_at)'), $request->from_date)->get();
                $lastmonthproducts = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->where(DB::raw('date(created_at)'), $request->from_date)->get();
                $sell = Billing::where(DB::raw('date(created_at)'), $request->from_date)->sum('deposit');

                //for suppliear due
                $total_supplier_due = Supplier_ladger::where(DB::raw('date(created_at)'), $request->from_date)->sum('due');

                //for customer due
                $total_customer_due = Billing::where(DB::raw('date(created_at)'), $request->from_date)->sum('due');
                //assets
                $asset = Asset::where(DB::raw('date(created_at)'), $request->from_date)->select(DB::raw('sum(price) as total'))
                    ->groupBy(DB::raw('(assetcategory_id)'))
                    ->selectRaw('assetcategory_id')
                    ->get();
                $totalasset = Asset::where(DB::raw('date(created_at)'), $request->from_date)->selectRaw('assetcategory_id')->sum('price');
                //bank Money
                $deposite = Bankmoney::where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')
                    ->where('type', 'deposite')
                    ->get()->sum('Amount');
                $withdraw = Bankmoney::where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')
                    ->where('type', 'withdraw')
                    ->get()->sum('Amount');

                //bankloan
                $deposit = Bankloan::where(DB::raw('date(created_at)'), $request->from_date)->where('loan_term', 'short')->where('loan_type', 'loan_deposite')->get()->sum('amount');
                $deposit_long = Bankloan::where(DB::raw('date(created_at)'), $request->from_date)->where('loan_term', 'long')->where('loan_type', 'loan_deposite')->get()->sum('amount');
                $deposit_interest_short = Bankloan::where(DB::raw('date(created_at)'), $request->from_date)->where('loan_term', 'short')->where('loan_type', 'loan_deposite')->get()->sum('interest');
                $deposit_interest_long = Bankloan::where(DB::raw('date(created_at)'), $request->from_date)->where('loan_term', 'long')->where('loan_type', 'loan_deposite')->get()->sum('interest');
                $withdraw_long = Bankloan::where(DB::raw('date(created_at)'), $request->from_date)->where('loan_term', 'long')->where('loan_type', 'loan_withdraw')->get()->sum('amount');
                $withdraw_short = Bankloan::where(DB::raw('date(created_at)'), $request->from_date)->where('loan_term', 'short')->where('loan_type', 'loan_withdraw')->get()->sum('amount');
                $withdraw_interest_long = Bankloan::where(DB::raw('date(created_at)'), $request->from_date)->where('loan_term', 'long')->where('loan_type', 'loan_withdraw')->get()->sum('interest');
                $withdraw_interest_short = Bankloan::where(DB::raw('date(created_at)'), $request->from_date)->where('loan_term', 'short')->where('loan_type', 'loan_withdraw')->get()->sum('interest');

            }
            if ($request->to_date) {

                //from income statement for cash and last inventory

                $totalwasted = Wasted_stock::where(DB::raw('date(created_at)'), $request->to_date)->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier', 'product.stock', 'product.stock.unit'])
                    ->get();
                $totalkitchenstock = Kitchen_stock::where(DB::raw('date(created_at)'), $request->to_date)->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier', 'product.stock', 'product.stock.unit'])
                    ->get();

                $monthlyexpanse = Expense::where(DB::raw('date(created_at)'), $request->to_date)->orderBy('id', 'DESC')->groupBy('expense_category_id')
                    ->selectRaw('sum(amount) as sum, expense_category_id')
                    ->get();
                $monthlyexpansesumation = Expense::where(DB::raw('date(created_at)'), $request->to_date)->orderBy('id', 'DESC')->get();

                $products = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->where(DB::raw('date(created_at)'), $request->to_date)->get();
                $lastmonthproducts = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->where(DB::raw('date(created_at)'), $request->to_date)->get();
                $sell = Billing::where(DB::raw('date(created_at)'), $request->to_date)->sum('deposit');

                //for suppliear due
                $total_supplier_due = Supplier_ladger::where(DB::raw('date(created_at)'), $request->to_date)->sum('due');

                //for customer due
                $total_customer_due = Billing::where(DB::raw('date(created_at)'), $request->to_date)->sum('due');
                //assets
                $asset = Asset::where(DB::raw('date(created_at)'), $request->to_date)->select(DB::raw('sum(price) as total'))
                    ->groupBy(DB::raw('(assetcategory_id)'))
                    ->selectRaw('assetcategory_id')
                    ->get();
                $totalasset = Asset::where(DB::raw('date(created_at)'), $request->to_date)->selectRaw('assetcategory_id')->sum('price');
                //bank Money
                $deposite = Bankmoney::where(DB::raw('date(created_at)'), $request->to_date)->orderBy('id', 'DESC')
                    ->where('type', 'deposite')
                    ->get()->sum('Amount');
                $withdraw = Bankmoney::where(DB::raw('date(created_at)'), $request->to_date)->orderBy('id', 'DESC')
                    ->where('type', 'withdraw')
                    ->get()->sum('Amount');

                //bankloan
                $deposit = Bankloan::where(DB::raw('date(created_at)'), $request->to_date)->where('loan_term', 'short')->where('loan_type', 'loan_deposite')->get()->sum('amount');
                $deposit_long = Bankloan::where(DB::raw('date(created_at)'), $request->to_date)->where('loan_term', 'long')->where('loan_type', 'loan_deposite')->get()->sum('amount');
                $deposit_interest_short = Bankloan::where(DB::raw('date(created_at)'), $request->to_date)->where('loan_term', 'short')->where('loan_type', 'loan_deposite')->get()->sum('interest');
                $deposit_interest_long = Bankloan::where(DB::raw('date(created_at)'), $request->to_date)->where('loan_term', 'long')->where('loan_type', 'loan_deposite')->get()->sum('interest');
                $withdraw_long = Bankloan::where(DB::raw('date(created_at)'), $request->to_date)->where('loan_term', 'long')->where('loan_type', 'loan_withdraw')->get()->sum('amount');
                $withdraw_short = Bankloan::where(DB::raw('date(created_at)'), $request->to_date)->where('loan_term', 'short')->where('loan_type', 'loan_withdraw')->get()->sum('amount');
                $withdraw_interest_long = Bankloan::where(DB::raw('date(created_at)'), $request->to_date)->where('loan_term', 'long')->where('loan_type', 'loan_withdraw')->get()->sum('interest');
                $withdraw_interest_short = Bankloan::where(DB::raw('date(created_at)'), $request->to_date)->where('loan_term', 'short')->where('loan_type', 'loan_withdraw')->get()->sum('interest');

            }
            if ($request->from_date && $request->to_date) {
                $products = Kitchen_stock::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->with(['product', 'product.brand', 'product.category', 'product.supplier', 'product.stock', 'product.stock.unit'])->orderBy('id', 'DESC')->get();

                //from income statement for cash and last inventory

                $totalwasted = Wasted_stock::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier', 'product.stock', 'product.stock.unit'])
                    ->get();
                $totalkitchenstock = Kitchen_stock::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier', 'product.stock', 'product.stock.unit'])
                    ->get();

                $monthlyexpanse = Expense::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->groupBy('expense_category_id')
                    ->selectRaw('sum(amount) as sum, expense_category_id')
                    ->get();
                $monthlyexpansesumation = Expense::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->get();

                $products = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->get();
                $lastmonthproducts = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->get();
                $sell = Billing::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->sum('deposit');

                //for suppliear due
                $total_supplier_due = Supplier_ladger::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->sum('due');

                //for customer due
                $total_customer_due = Billing::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->sum('due');
                //assets
                $asset = Asset::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->select(DB::raw('sum(price) as total'))
                    ->groupBy(DB::raw('(assetcategory_id)'))
                    ->selectRaw('assetcategory_id')
                    ->get();
                $totalasset = Asset::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->selectRaw('assetcategory_id')->sum('price');
                //bank Money
                $deposite = Bankmoney::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')
                    ->where('type', 'deposite')
                    ->get()->sum('Amount');
                $withdraw = Bankmoney::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')
                    ->where('type', 'withdraw')
                    ->get()->sum('Amount');

                //bankloan
                $deposit = Bankloan::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->where('loan_term', 'short')->where('loan_type', 'loan_deposite')->get()->sum('amount');
                $deposit_long = Bankloan::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->where('loan_term', 'long')->where('loan_type', 'loan_deposite')->get()->sum('amount');
                $deposit_interest_short = Bankloan::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->where('loan_term', 'short')->where('loan_type', 'loan_deposite')->get()->sum('interest');
                $deposit_interest_long = Bankloan::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->where('loan_term', 'long')->where('loan_type', 'loan_deposite')->get()->sum('interest');
                $withdraw_long = Bankloan::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->where('loan_term', 'long')->where('loan_type', 'loan_withdraw')->get()->sum('amount');
                $withdraw_short = Bankloan::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->where('loan_term', 'short')->where('loan_type', 'loan_withdraw')->get()->sum('amount');
                $withdraw_interest_long = Bankloan::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->where('loan_term', 'long')->where('loan_type', 'loan_withdraw')->get()->sum('interest');
                $withdraw_interest_short = Bankloan::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->where('loan_term', 'short')->where('loan_type', 'loan_withdraw')->get()->sum('interest');


            }



            $currentDateTime = Carbon::now()->format('l-M-Y');

            $data = [
                'page_title' => 'Balance Sheet :: Jannat Restaurant & Resort',
                'page_header' => 'Balance Sheet',
                'page_desc' => '',
                'assets'    =>$asset,
                'totalassets' =>$totalasset,
                'deposite'  => $deposite,
                'withdraw'  => $withdraw,
                //for cash from income statement
                'products' => $products,
                'lastmonthproducts' => $lastmonthproducts,
                'sells' => $sell,
                'expenses' => $monthlyexpanse,
                'monthlyexpansesumation' => $monthlyexpansesumation,
                'totalwasted' => $totalwasted,
                'totalkitchenstock' => $totalkitchenstock,
                'total_supplier_dues' => $total_supplier_due,
                'total_customer_dues' => $total_customer_due,
                'total_account_receivables' => $total_supplier_due + $total_customer_due,
                'total_investments' => Investment::whereYear(DB::raw('date(created_at)'), Carbon::now()->year)->sum('amount'),
                //bankloan
                'deposit' => $deposit,
                'deposit_long' => $deposit_long,
                'deposit_interest_short' => $deposit_interest_short,
                'deposit_interest_long'    => $deposit_interest_long,
                'withdraw_long'            => $withdraw_long,
                'withdraw_short'           => $withdraw_short,
                'withdraw_interest_long'   => $withdraw_interest_long,
                'withdraw_interest_short'  => $withdraw_interest_short,
                'currentDateTime' => $currentDateTime,

            ];

            return view('balancesheet.balancesheet-filter')->with(array_merge($this->data, $data));
        }


    }
}

