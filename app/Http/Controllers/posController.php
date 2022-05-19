<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuCategory;
use App\Customer;
use Illuminate\Http\Request;
use DB;
use App\Order_menu_mapping;
use App\Order;
use App\Billing;
use PDF;
use Carbon\Carbon;
use App\Setting;
use Auth;

class posController extends Controller
{
    //
    public function index()
    {
        $data = [
            'page_title' => 'Pos',
            'page_header' => 'POS',
            'page_desc' => '',
            'menus' => Menu::all(),
            'menu_categories' => MenuCategory::all(),
            'settings' => Setting::first(),
            'customers' => Customer::all()
        ];

        return view('pos.index')->with(array_merge($this->data, $data));
    }

    public function billingStore(Request $request)
    {
        try{

            DB::beginTransaction();
            //make menu
                $order                           = new Order();
                $order->restaurant_id            = 1;
                $y =Carbon::now()->format('y');
                $m = Carbon::now()->format('m');
                $d = Carbon::now()->format('d');
                $prefix = $y.$m.$d;
                //existing order_no check
                $orders = Order::latest()->get();
                if(count($orders) > 0) {
                    $order_no = $orders->first()->order_no;
                    $div = explode($prefix, $order_no);

                    if(isset($div[1])){
                        $order_no++;
                    } else {
                        $order_no = $prefix.'0001';
                    }
                }
                else {
                    //if there is no order no in table [first order ino]
                    $order_no = $prefix . '0001';
                }


            $order->order_no              = $order_no;
            $order->waiter_id                = \Auth::user()->id;
            $order->table_id                 = 1;
            $order->sub_total                = $request->subtotal;
            $order->discount                 = $request->discount;
            $order->tax                      = $request->vat;
            $order->amount                   = $request->total;
            $order->status                   = 2;
            $order->created_by               = \Auth::user()->email;
            $order->save();

            //Order to Order Menu maping

            $order_menus= $request->menu_id;
            $quantities = $request->quantity;
            $prices = $request->menu_price;

            foreach ($order_menus as $key => $order_menu)
            {
                $order_menu_map = new Order_menu_mapping();
                $order_menu_map->order_id = $order->id;
                $order_menu_map->menu_id = $order_menu;
                $order_menu_map->cost = Menu::find($order_menu) ? Menu::find($order_menu)->cost : 0;
                $order_menu_map->sell_price = Menu::find($order_menu) ? Menu::find($order_menu)->price : 0;
                $order_menu_map->quantity = $quantities[$key];
                $order_menu_map->price = $prices[$key];
                $order_menu_map->type= 0;
                $order_menu_map->save();
            }

            $order_menu_mappinges =Order_menu_mapping::with('menu')->where('order_id',$order->id)->get();
            $total_profit = 0;
            foreach($order_menu_mappinges as $key => $menu) {
                $cost = $menu->cost*$menu->quantity;
                $profit = $menu->price - $cost;
                $total_profit += $profit;
            }


            //create billing
            $billing = new Billing();
            $billing->customer_id   = $request->customer;
            $billing->order_id      = $order->id;
            $billing->deposit       = $request->deposit;
            $billing->type          = $request->deposit_type;
            $billing->transaction   = $request->transaction;
            $billing->card          = $request->card;
            $billing->due           = $request->due;
            $billing->profit        = $total_profit;
            $billing->created_by    = \Auth::user()->email;
            $billing->save();



            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect_newtab'  => route('billing.print_view', $billing->order_id), 'redirect' => route('pos'), 'message' => 'Bill Add Successfully'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Ordered'];
        }
    }

    //store product
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'kitchen_id' => 'required',
//        ]);
        try{

            DB::beginTransaction();
            //make menu
            $order                           = new Order();
            $order->restaurant_id            = 1;
            $y =Carbon::now()->format('y');
            $m = Carbon::now()->format('m');
            $d = Carbon::now()->format('d');
            $prefix = $y.$m.$d;
            //existing order_no check
            $orders = Order::latest()->get();
            if(count($orders) > 0) {
                $order_no = $orders->first()->order_no;
                $div = explode($prefix, $order_no);

                if(isset($div[1])){
                    $order_no++;
                } else {
                    $order_no = $prefix.'0001';
                }
            }
            else {
                //if there is no order no in table [first order ino]
                $order_no = $prefix . '0001';
            }


            $order->order_no              = $order_no;
            $order->waiter_id                = \Auth::user()->id;
            $order->table_id                 = 0;
            $order->kitchen_id               = $request->kitchen_id;
            $order->sub_total                = $request->subtotal;
            $order->discount                 = $request->discount;
            $order->tax                      = $request->vat;
            $order->amount                   = $request->total;
            $order->status                   = 1;
            $order->discount                 = $request->discount;
            $order->created_by               = \Auth::user()->email;
            $order->save();

            //Order to Order Menu maping

            $order_menus= $request->menu_id;
            $quantities = $request->quantity;
            $prices = $request->menu_price;

            foreach ($order_menus as $key => $order_menu)
            {
                $order_menu_map = new Order_menu_mapping();
                $order_menu_map->order_id = $order->id;
                $order_menu_map->menu_id = $order_menu;
                $order_menu_map->cost = Menu::find($order_menu) ? Menu::find($order_menu)->cost : 0;
                $order_menu_map->sell_price = Menu::find($order_menu) ? Menu::find($order_menu)->price : 0;
                $order_menu_map->quantity = $quantities[$key];
                $order_menu_map->price = $prices[$key];
                $order_menu_map->type= 0;
                $order_menu_map->save();
            }


            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('pos'),  'message' => 'Order has been Successfully'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Ordered'];
        }
    }


}
