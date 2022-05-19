<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Dashboard :: Jannat Restaurant & Resort',
            'page_header' => 'Dasbhoard',
            'page_description' => ' ',
            'total_profit' => Billing::sum('profit'),
            'total_sell' => Order::where('status', 2)->get(),
            'today_profit' => Billing::whereDate('created_at', Carbon::today())->sum('profit'),
            'today_sell' => Order::where('status', 2)->whereDate('created_at', Carbon::today())->get(),
        ];
        return view('cashier.index')->with(array_merge($this->data, $data));
    }
}
