<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order_menu_mapping;
use App\Order;
use App\Customer;
use App\Menu;
use App\Billing;

class PrintController extends Controller
{
    public function printView(Request $request, $order_id)
    {
        $data = [
            'page_title'  => 'Order_list Panel',
            'page_header' => 'Jannat Restaurant & Resort',
            'address'   => 'Address',
            'orders'      => Order::find($order_id),
            'billings'      => Billing::where('order_id',$order_id)->first(),
            'order_menu_mappinges' => Order_menu_mapping::where('order_id',$order_id)->get(),
        ];
        
        return view('printpriview.preview')->with(array_merge($this->data, $data));
    }

    public function OrderPrintView(Request $request, $order_id)
    {
        $data = [
            'page_title'  => 'Order_list Panel',
            'page_header' => 'Jannat Restaurant & Resort',
            'address'   => 'Address',
            'orders'      => Order::find($order_id),
            'order_menu_mappinges' => Order_menu_mapping::where('order_id',$order_id)->get(),
        ];
        
        return view('printpriview.order-preview')->with(array_merge($this->data, $data));
    }

    //token
    public function orderToken($id)
    {
        $data = [
            'page_title'  => 'Order_list Panel',
            'page_header' => 'Jannat Restaurant & Resort',
            'address'   => 'Address',
            'order'      => Order::find($id),
            'order_menus' => Order_menu_mapping::where('order_id',$id)
                ->groupBy('menu_id')
                ->selectRaw('menu_id')
                ->selectRaw('sum(price) as price')
                ->selectRaw('sum(quantity) as quantity')
                ->get(),
        ];

        return view('printpriview.order-token')->with(array_merge($this->data, $data));
    }


    //token
    public function reOrderToken($id)
    {
        $data = [
            'page_title'  => 'Order_list Panel',
            'page_header' => 'Jannat Restaurant & Resort',
            'address'   => 'Address',
            'order'      => Order::find($id),
            'order_menus' => Order_menu_mapping::where('order_id', $id)->where('type', 1)->where('served_status', 0)
                ->groupBy('menu_id')
                ->selectRaw('menu_id')
                ->selectRaw('sum(price) as price')
                ->selectRaw('sum(quantity) as quantity')
                ->get(),
        ];

        return view('printpriview.order-token')->with(array_merge($this->data, $data));
    }


}
