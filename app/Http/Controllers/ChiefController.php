<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Order;
use App\Order_menu_mapping;
use Illuminate\Http\Request;
use App\KitchenChief;
use Session;

class ChiefController extends Controller
{
    //
    public function index()
    {
        if(!Auth::user()->canDo(['manage_chief'])) {
            return abort('401');
        }

        $orders = Order::all();

        $data = [
            'page_title' => 'Chief Panel',
            'page_header' => 'Chief Panel',
            'page_desc' => '',
            'orders' => $orders
        ];

        return view('chief.index')->with(array_merge($this->data, $data));
    }

    public function orderLoad()
    {
        if(!Auth::user()->canDo(['manage_chief'])) {
            return abort('401');
        }

        $kitchenChief= KitchenChief::where('user_id', Auth::user()->id)->first();

        $kitchen_id = $kitchenChief->kitchen_id;

        if(session()->has('previous_orders')) {
            
        } else {
            Session::put('previous_orders', 0);
        }

        $orders = Order::where('status', 0)->where('kitchen_id', $kitchen_id)->whereDate('created_at', \Carbon\Carbon::today())->get();
        $count_orders = count($orders);
        
        Session::put('total_orders', $count_orders);

        $previous_orders = Session::get('previous_orders');
        $total_orders = Session::get('total_orders');

        if($previous_orders < $total_orders) {
            Session::put('get_sound', 'on');
            Session::put('previous_orders', $total_orders);
        } else {
            Session::put('get_sound', 'off');
            Session::put('previous_orders', $total_orders);
        }
        
        $data = [
            'page_title' => 'Chief Panel',
            'page_header' => 'Chief Panel',
            'page_desc' => '',
            'orders' => $orders
        ];

        return view('chief.orders')->with(array_merge($this->data, $data));
    }

    public function reorderLoad()
    {
        if(!Auth::user()->canDo(['manage_chief'])) {
            return abort('401');
        }

        $kitchenChief= KitchenChief::where('user_id', Auth::user()->id)->first();

        $kitchen_id = $kitchenChief->kitchen_id;

        if(session()->has('previous_reorders')) {

        } else {
            Session::put('previous_reorders', 0);
        }

        $orders = Order::where('status', 1)->where('kitchen_id', $kitchen_id)->whereDate('created_at', \Carbon\Carbon::today())->get();

        $order_ids = $orders->pluck('id');

        $menus_order = Order_menu_mapping::whereIn('order_id', $order_ids)
        ->where('type', 1)->where('served_status', 0)->get()->pluck('order_id');

        $orders = Order::whereIn('id', $menus_order)->get();

        $count_orders = count($orders);

        Session::put('total_reorders', $count_orders);

        $previous_reorders = Session::get('previous_reorders');
        $total_reorders = Session::get('total_reorders');

        if($previous_reorders < $total_reorders) {
            Session::put('get_reorder_sound', 'on');
            Session::put('previous_reorders', $total_reorders);
        } else {
            Session::put('get_reorder_sound', 'off');
            Session::put('previous_reorders', $total_reorders);
        }


        $data = [
            'page_title' => 'Chief Panel',
            'page_header' => 'Chief Panel',
            'page_desc' => '',
            'orders' => $orders
        ];

        return view('chief.re-order')->with(array_merge($this->data, $data));
    }

    public function orderPepared(Request $request) 
    {
        try{

            DB::beginTransaction();
            //change status of the menus which is served
            $menus = Order_menu_mapping::where('order_id', $request->order_id)->where('served_status', 0)->update(['served_status' => 1]);
            

            $order = Order::find($request->order_id);
            $order->confirm_status = 1;
            $order->chief_id = \Auth::user()->id;
            $order->save();

            DB::commit();

            return ['type' => 'success', 'title' => 'Order Prepared' ,'redirect' => route('chief.dashboard'), 'message' => 'Order served'];
        }
        catch(\Throwable $e) {
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Something went wrong, Order didnot served'];
        }
    }

    public function report(Request $request)
    {
        $orders = Order::where('status', 2)->where('chief_id', Auth::user()->id)->orderBy('id', 'DESC')->get();

        if($request->from_date || $request->to_date){
            if($request->from_date) {
                $orders = Order::where('status', 2)->where('chief_id', Auth::user()->id)->where(DB::raw('date(created_at)'), $request->from_date)->orderBy('id', 'DESC')->get();
            }
            if($request->from_date && $request->to_date)
            {
                $orders = Order::where('status', 2)->where('chief_id', Auth::user()->id)->whereBetween(DB::raw('date(created_at)'), [$request->from_date, $request->to_date])->orderBy('id', 'DESC')->get();
            }

            $data = [
                'page_title' => 'Kitchen Report',
                'page_header' => 'Kitchen Report',
                'page_desc' => '',
                'orders' => $orders
            ];
            
            return view('chief.search-report')->with(array_merge($this->data, $data));
        }

        $data = [
            'page_title' => 'Kitchen Report',
            'page_header' => 'Kitchen Report',
            'page_desc' => '',
            'orders' => $orders
        ];


        return view('chief.reports')->with(array_merge($this->data, $data));

    }


}
