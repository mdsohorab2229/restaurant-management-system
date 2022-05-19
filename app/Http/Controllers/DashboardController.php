<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Order;
use App\Billing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->canDo(['manage_admin','manage_cash'])) {
            $data = [
                'page_title' => 'Dashboard :: Jannat Restaurant & Resort',
                'page_header' => 'Dasbhoard',
                'page_description' => ' ',
                'total_profit' => Billing::sum('profit'),
                'total_sell' => Order::where('status', 2)->get(),
                'today_profit' => Billing::whereDate('created_at', Carbon::today())->sum('profit'),
                'today_sell' => Order::where('status', 2)->whereDate('created_at', Carbon::today())->get(),
                'all_bills' => Billing::all('profit'),
            ];

            return view('dashboard.index')->with(array_merge($this->data, $data));
        }

        else if (Auth::user()->canDo('manage_waiter')) {
            return redirect()->route('waiter.dashboard');
        }

        else if (Auth::user()->canDo('manage_chief')) {
            return redirect()->route('chief.dashboard');
        }

        else if (Auth::user()->canDo('manage_store')) {
            $data = [
                'page_title' => 'Dashboard :: Jannat Restaurant & Resort',
                'page_header' => 'Dasbhoard',
                'page_description' => ' ',
            ];

            return view('dashboard.store')->with(array_merge($this->data, $data));
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
            //dd(database_formatted_date(Carbon::today()));
            if($hide){
                $today_orders = Order::whereDate('created_at', Carbon::today())->where('status', 2)->orderBy('id', 'DESC')->get();
                $count = count($today_orders);
                $target = ceil($count*($hide/100));
                $today_orders = $today_orders->take($target);
                $today_orders_ids = $today_orders->pluck('id');
            }

            //$dogs = Dogs::orderBy('id', 'desc')->take(5)->get();
            $data = [
                'page_title' => 'Dashboard :: Jannat Restaurant & Resort',
                'page_header' => 'Dasbhoard',
                'page_description' => ' ',
                'total_profit' => Billing::whereIn('order_id', $order_ids)->sum('profit'),
                'total_sell' => $orders,
                'today_profit' => Billing::whereIn('order_id', $today_orders_ids)->whereDate('created_at', Carbon::today())->sum('profit'),
                'today_sell' => $today_orders,
            ];

            return view('dashboard.index')->with(array_merge($this->data, $data));
        }

    }
}
