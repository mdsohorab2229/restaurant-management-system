<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Expense;
use App\Order;
use App\Menu;
use App\Billing;
use App\User;
use App\Product;
use App\Kitchen_stock;
use App\Wasted_stock;
use App\Order_menu_mapping;
use Illuminate\Http\Request;
use DB;
use Auth;
class ReportController extends Controller
{
    //
    public function stock()
    {
        $data = [
            'page_title' => 'Stock Report',
            'page_header' => 'Stock Report',
            'page_desc' => ''
        ];

        return view('reports.stock')->with(array_merge($this->data, $data));
    }
    public function searchstock(Request $request)
    {
        if ($request->from_date || $request->to_date) {
            if ($request->from_date) {
                $products = Product::where(DB::raw('date(created_at)'), $request->from_date)->with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->orderBy('id', 'DESC')->get();
            }
            if ($request->from_date && $request->to_date) {
                $products = Product::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->orderBy('id', 'DESC')->get();


            }

            $data = [
                'page_title' => 'Stock Report',
                'page_header' => 'Stock Report',
                'page_desc' => '',
                'products' => $products,
                'form_date' => $request->from_date,
                'to_date' => $request->to_date,
            ];

            return view('reports.search-stock')->with(array_merge($this->data, $data));
        }
    }

    public function kitchenstore()
    {
        $products =  Product::all();
        $data = [
            'page_title' => 'Kitchen Stock',
            'page_header' => 'Kitchen Stock',
            'page_desc' => '',
            'products' => $products
        ];

        return view('reports.kitchen-store')->with(array_merge($this->data, $data));
    }

    public function searchkitchenstore(Request $request)
    {
        if ($request->from_date || $request->to_date) {
            if ($request->from_date) {
                $products = Kitchen_stock::where(DB::raw('date(created_at)'), $request->from_date)->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC')->get();
            }
            if ($request->from_date) {
                $products = Kitchen_stock::where(DB::raw('date(updated_at)'), $request->from_date)->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC')->get();
            }
            if ($request->from_date && $request->to_date) {
                $products = Kitchen_stock::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC')->get();
            }

            if ($request->from_date && $request->to_date) {
                $products = Kitchen_stock::whereBetween(DB::raw('date(updated_at)'), [$request->from_date, $request->to_date])->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC')->get();
            }

            $data = [
                'page_title' => 'Kitchen Stock Report',
                'page_header' => 'Kitchen Stock Report',
                'page_desc' => '',
                'products' => $products,
                'form_date' => $request->from_date,
                'to_date' => $request->to_date,
            ];

            return view('reports.search-kitchen-store')->with(array_merge($this->data, $data));
        }
    }


    public function wasted()
    {
        $data = [
            'page_title' => 'Wasted Report',
            'page_header' => 'Wasted Report',
            'page_desc' => ''
        ];

        return view('reports.wasted')->with(array_merge($this->data, $data));
    }

    public function searchwasted(Request $request)
    {

        if ($request->from_date || $request->to_date) {
            if ($request->from_date) {
                $products = Wasted_stock::where(DB::raw('date(updated_at)'), $request->from_date)->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC')->get();

            }
            else if ($request->from_date)
            {
                $products = Wasted_stock::where(DB::raw('date(created_at)'), $request->from_date)->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC')->get();

            }
            if ($request->from_date && $request->to_date) {

                $products = Wasted_stock::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC')->get();
            }
           else if ($request->from_date && $request->to_date) {

                $products = Wasted_stock::whereBetween(DB::raw('date(updated_at)'), [$request->from_date, $request->to_date])->with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC')->get();
            }

            $data = [
                'page_title' => 'Wasted Store Report',
                'page_header' => 'Wasted Store Report',
                'page_desc' => '',
                'products' => $products,
                'form_date' => $request->from_date,
                'to_date' => $request->to_date,
            ];

            return view('reports.search-wasted-stock')->with(array_merge($this->data, $data));
        }
    }

    public function sell(Request $request)
    {
        if(Auth::user()->canDo('manage_admin')) {
            $invoices = Billing::orderBy('id', 'DESC');
        } 
        else if (Auth::user()->canDo('manage_jannat')) {
            $hide = getHideVal();
            if($hide==null) {
                $hide =100;
            }
            if($hide){
                $orders = Order::orderBy('id', 'desc')->where('status', 2)->get();
                $count = count($orders);
                $target = ceil($count*($hide/100));
                $orders = $orders->take($target);
                $order_ids = $orders->pluck('id');
            }
            $invoices = Billing::whereIn('order_id', $order_ids)->orderBy('id', 'DESC');
        }

        if($request->from_date || $request->to_date){
            $invoices->Where(DB::raw('date(created_at)'), $request->from_date) ;
            $invoices->orwhereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date]) ;
        }

        $invoices = $invoices->paginate(20);

        $data = [
            'page_title' => 'Sell Report',
            'page_header' => 'Sell Report',
            'page_desc' => '',
            'invoices' => $invoices
        ];

        return view('reports.invoice')->with(array_merge($this->data, $data));
    }

    public function profit(Request $request)
    {
        if(Auth::user()->canDo('manage_admin')) {
            $orders = Order::where('status', 2);
        }
        else if (Auth::user()->canDo('manage_jannat')) {
            $hide = getHideVal();
            if($hide==null) {
                $hide =100;
            }
            if($hide){
                $orders = Order::orderBy('id', 'desc')->where('status', 2)->get();
                $count = count($orders);
                $target = ceil($count*($hide/100));
                $orders = $orders->take($target);
                $order_ids = $orders->pluck('id');
            }
            
            $orders = Order::where('status', 2)->whereIn('id', $order_ids);
        }

        $all_menus = Menu::paginate(10);


        if($request->from_date || $request->to_date){
            $orders->Where(DB::raw('date(created_at)'), $request->from_date) ;
            $orders->orwhereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date]) ;
        }

        $orders = $orders->get();
        $order_ids = $orders->pluck('id');

        $order_menus = Order_menu_mapping::whereIn('order_id', $order_ids);


        if($request->menu_name) {
            $order_menus = $order_menus->where('menu_id', $request->menu_name);
        }

        $order_menus =  $order_menus->get()->groupBy('menu_id');
        
        $profits = [];

        if($order_menus) {
            foreach($order_menus as $key => $menu) {

                $cost = 0;
                $quantity = $menu->sum('quantity');
                $price = $menu->sum('price');
                $profit = 0;

                foreach($menu as $key => $m) {
                    $name=$m->menu ? $m->menu->name : '-';
                    $this_cost = $m->quantity * $m->cost;
                    $this_profit = $m->price-$this_cost;
                    $profit += $this_profit;
                    $cost += $this_cost;
                }

                $profits[] = ['name' => $name, 'quantity' => $quantity, 'cost' => $cost, 'price' => $price, 'profit' => $profit];
            }
        }

        $menus = collect($profits);

        $data = [
            'page_title' => 'Profit Report',
            'page_header' => 'Profit Report',
            'page_desc' => '',
            'menus' => $menus,
            'all_menus' => $all_menus
        ];

        return view('reports.profit')->with(array_merge($this->data, $data));
    }

    public function cashier(Request $request)
    {
//        $a=$request->from_date;
//        $b=explode('-',$a);
//        $c=strtoupper($b[1]);
//        $d=trim($c);
//        $e=$b[0];
//        $f=explode(' ',$e);
//        $g=substr($f[1],0,3);
//        $h=substr($f[2],-2);
//        $i=array($f[0],$g,$h, $d);
//        $j=implode(",",$i);
//        dd($j);

        if(Auth::user()->canDo('manage_admin')) {
            $billings = Billing::orderBy('id', 'DESC')->get();
        }
        else if(Auth::user()->canDo('manage_cash')) {
            $billings = Billing::orderBy('id', 'DESC')->where('created_by',Auth::user()->email)->get();
        }



//        dd($billings[1]->created_at);
        if ($request->from_date || $request->to_date) {
            if ($request->from_date) {
                $billings = Billing::where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')->get();
            }
            if ($request->from_date && $request->to_date) {
                $billings = Billing::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->where('created_by',Auth::user()->email)->get();
            }

            $data = [
                'page_title' => 'Cashier Report',
                'page_header' => 'Cashier Report',
                'page_desc' => '',
                'billings' => $billings,
                'form_date' => $request->from_date,
                'to_date' => $request->to_date,
            ];

            return view('reports.search-cashier')->with(array_merge($this->data, $data));
        }

            $data = [
                'page_title' => 'Cashier Report',
                'page_header' => 'Cashier Report',
                'page_desc' => '',
                'billings' => $billings,
            ];

            return view('reports.cashier')->with(array_merge($this->data, $data));
        }


    public function kitchen(Request $request)
    {
        $orders = Order::where('status', 2)->orderBy('id', 'DESC')->get();

        if($request->from_date || $request->to_date){
            if($request->from_date) {
                $orders = Order::where('status', 2)->where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')->get();
            }
            if($request->from_date && $request->to_date)
            {
                $orders = Order::where('status', 2)->whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->get();
            }

            $data = [
                'page_title' => 'Kitchen Report',
                'page_header' => 'Kitchen Report',
                'page_desc' => '',
                'orders' => $orders,
                'form_date' => $request->from_date,
                'to_date' => $request->to_date,
            ];
            
            return view('reports.search-report')->with(array_merge($this->data, $data));
        }

        $data = [
            'page_title' => 'Kitchen Report',
            'page_header' => 'Kitchen Report',
            'page_desc' => '',
            'orders' => $orders
        ];


        return view('reports.kitchen')->with(array_merge($this->data, $data));
    }

    public function income()
    {

        $allexpenses = Expense::orderBy('id', 'DESC')->where(DB::raw('date(created_at)'), Carbon::today())->groupBy('expense_category_id')
            ->selectRaw('sum(amount) as sum, expense_category_id')->get();

        $sell = Billing::where(DB::raw('date(created_at)'), Carbon::today())->sum('deposit');
        $data = [
            'page_title' => 'Income Statement Report',
            'page_header' => 'Income Statement Report',
            'page_desc' => '',
            'allexpenses' => $allexpenses,
            'sells'   => $sell,
        ];


        return view('reports.income')->with(array_merge($this->data, $data));
    }

    //for income statement final report

    public function reportincome(Request $request)
    {


        if ($request->from_date || $request->to_date) {
            if ($request->from_date) {

                $allexpenses = Expense::where(DB::raw('date(expense_date)'), $request->from_date)->orderBy('id', 'DESC')->groupBy('expense_category_id')
                    ->selectRaw('sum(amount) as sum, expense_category_id')
                    ->get();
                $expenses = Expense::where(DB::raw('date(expense_date)'), $request->from_date)->orderBy('id', 'DESC')->get();

                $sell = Billing::where(DB::raw('date(created_at)'), $request->from_date)->sum('deposit');

            }
            if ($request->from_date && $request->to_date) {

                $allexpenses = Expense::whereBetween(DB::raw('date(expense_date)'), [$request->from_date, $request->to_date])->groupBy('expense_category_id')
                    ->selectRaw('sum(amount) as sum, expense_category_id')->get();
                $expenses = Expense::whereBetween(DB::raw('date(expense_date)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->get();

                $sell = Billing::whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->sum('deposit');

            }

            $data = [
                'page_title' => 'Income Statement Report',
                'page_header' => 'Income Statement Report',
                'page_desc' => '',
                'allexpenses' => $allexpenses,
                'sells'   => $sell,
                'expenses' => $expenses,
            ];

            return view('reports.search-income')->with(array_merge($this->data, $data));
        }
    }


    
}
