<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Purchase_category;
use App\Product;
use App\Billing;
use App\Expense;
use App\Wasted_stock;
use App\Kitchen_stock;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PurchaseController extends Controller
{
//    public function index()
//    {
//        $categories = Purchase_category::all();
//        $total_purchase = Purchase::sum('amount');
//        $data = [
//            'page_title' => 'Purchase',
//            'page_header' => 'Purchase',
//            'page_desc' => '',
//            'categories' => $categories,
//            'total_purchase' => $total_purchase
//        ];
//
//        return view('purchase.index')->with(array_merge($this->data, $data));
//
//    }

    public function index()
    {
        $products = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->whereMonth('created_at', Carbon::now()->month)->get();
        $lastmonthproducts = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->whereMonth('created_at', Carbon::now()->subMonth()->month)->get();
        $sell = Billing::whereMonth(DB::raw('date(created_at)'), Carbon::now()->month)->sum('deposit');
        $data = [
            'page_title' => 'Purchase',
            'page_header' => 'Purchase',
            'page_desc' => '',
            'products' => $products,
            'lastmonthproducts' => $lastmonthproducts,
            'sells'   => $sell,
        ];

        return view('purchase.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' =>'required'
            
        ]);

        $purchase = new Purchase();
        $purchase->purchase_category_id = $request->purchase_category;
        $purchase->title = $request->title;
        $purchase->description = $request->description;
        $purchase->amount = $request->amount;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->created_by = \Auth::user()->email;
        
        if($purchase->save()) {
            return ['type' => 'success', 'title' => 'Success!', 'redirect'  => route('purchase.list') ,'message' => 'Purchase has been saved Successfully'];
        } 
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Customer'];
    }

    public function purchasereport(Request $request)
    {
        if ($request->from_date || $request->to_date) {
            if($request->from_date)
            {
                $allproducts = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')->get();
            }

            if ($request->from_date && $request->to_date) {
                $allproducts = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->whereBetween(DB::raw('date(created_at)'), [$request->from_date,$request->to_date])->orderBy('id', 'DESC')->get();

            }

            $data = [
                'page_title' => 'Purchase',
                'page_header' => 'Purchase',
                'page_desc' => '',
                'products' => $allproducts,
            ];

            return view('purchase.report')->with(array_merge($this->data, $data));

        }
    }

    //for income statement

    public function incomestatement()
    {
        $totalwasted = Wasted_stock::whereMonth('created_at', Carbon::now()->month)->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])
            ->get();
        $totalkitchenstock = Kitchen_stock::whereMonth('created_at', Carbon::now()->month)->orderBy('id', 'DESC')->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])
            ->get();

        $monthlyexpanse = Expense::whereMonth('created_at', Carbon::now()->month)->orderBy('id', 'DESC')->groupBy('expense_category_id')
            ->selectRaw('sum(amount) as sum, expense_category_id')
            ->get();
        $monthlyexpansesumation = Expense::whereMonth('created_at', Carbon::now()->month)->orderBy('id', 'DESC')->get();

        $products = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->whereMonth('created_at', Carbon::now()->month)->get();
        $lastmonthproducts = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->whereMonth('created_at', Carbon::now()->subMonth()->month)->get();
        $sell = Billing::whereMonth(DB::raw('date(created_at)'), Carbon::now()->month)->sum('deposit');
        $data = [
            'page_title' => 'Income Statement',
            'page_header' => 'Income Statement',
            'page_desc' => '',
            'products' => $products,
            'lastmonthproducts' => $lastmonthproducts,
            'sells'   => $sell,
            'expenses'   => $monthlyexpanse,
            'monthlyexpansesumation' => $monthlyexpansesumation,
            'totalwasted' => $totalwasted,
            'totalkitchenstock' => $totalkitchenstock,
        ];

        return view('purchase.incom-statement')->with(array_merge($this->data, $data));
    }

    public function searchIncomestatement( Request $request )
    {
        if ($request->from_date || $request->to_date) {
            if ($request->from_date) {
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

            }

            if ($request->from_date && $request->to_date) {

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


            }


            $data = [
                'page_title' => 'Income Statement',
                'page_header' => 'Purchase Statement',
                'page_desc' => '',
                'products' => $products,
                'lastmonthproducts' => $lastmonthproducts,
                'sells' => $sell,
                'expenses' => $monthlyexpanse,
                'monthlyexpansesumation' => $monthlyexpansesumation,
                'totalwasted' => $totalwasted,
                'totalkitchenstock' => $totalkitchenstock,
            ];

            return view('purchase.search-incom-statement')->with(array_merge($this->data, $data));

        }
    }

}
