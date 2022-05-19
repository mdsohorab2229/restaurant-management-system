<?php

namespace App\Http\Controllers;

use App\Order_menu_mapping;
use App\Setting;
use Illuminate\Http\Request;
use Auth;
use App\Menu;
use App\MenuCategory;
use App\Menu_menucategory_mapping;
use App\Table;
use App\Order;
use App\Kitchen;
use Session;
class WaiterController extends Controller
{
    
    public function index()
    {
        if(!Auth::user()->canDo(['manage_waiter','manage_cash'])) {
            return abort('401');
        }
        $pendingOrder  = Order::where('waiter_id', Auth::user()->id)->where('status', 0)->get();
        $ongoingOrder  = Order::where('waiter_id', Auth::user()->id)->where('status', 1)->get();
        $completeOrder = Order::where('waiter_id', Auth::user()->id)->where('status', 2)->get();

        $data = [
            'page_title'  => 'Waiter Panel',
            'page_header' => 'Waiter Panel',
            'page_desc'   => '',
            'orders'      => Order::all(),
            'order_menu_mappinges' => Order_menu_mapping::all(),
            'pending' => count($pendingOrder),
            'ongoing' => count($ongoingOrder),
            'complete' => count($completeOrder),
        ];

        return view('waiter.index')->with(array_merge($this->data, $data));
    }
    
    public function table()
    {
        if(!Auth::user()->canDo(['manage_waiter','manage_cash'])) {
            return abort('401');
        } 
        $ordered_table = Order::where('status', 0)->orWhere('status', 1)->get()->pluck('table_id');
        $tables = Table::all();
        $data = [
            'page_title' => 'Select table',
            'page_header' => 'Select table',
            'page_desc' => '',
            'tables' => $tables,
            'ordered_table' => $ordered_table
        ];

        return view('waiter.table')->with(array_merge($this->data, $data));
    }

    public function tableOrder($id)
    {
        if(!Auth::user()->canDo(['manage_waiter','manage_cash'])) {
            return abort('401');
        } 
        $data = [
            'page_title' => 'Menu Ordering',
            'page_header' => 'Menu Ordering',
            'page_desc' => '',
            'table_id' => $id,
            'menus' => Menu::all(),
            'settings' => Setting::first(),
            'menu_categories' => MenuCategory::all(),
            'kitchens'  => Kitchen::all(),

        ];

        return view('waiter.menulist')->with(array_merge($this->data, $data));
    }

    public function extraOrder($id)
    {
        if(!Auth::user()->canDo(['manage_waiter','manage_cash'])) {
            return abort('401');
        }

        $data = [
            'page_title' => 'Extra Ordering',
            'page_header' => 'Extra Ordering',
            'page_desc' => '',
            'order_id' => $id,
            'menus' => Menu::all(),
            'menu_categories' => MenuCategory::all(),
            'settings' => Setting::first(),

        ];

        return view('waiter.extra-order')->with(array_merge($this->data, $data));
    }


    public function findMenu(Request $request)
    {
        if(!Auth::user()->canDo(['manage_waiter','manage_cash'])) {
            return abort('401');
        } 

        $menu = Menu::find($request->menu_id);
        
        return $menu;
    }


    public function findCategory(Request $request) 
    {
        $output = ''; 
        if($request->category) {
            $menus_category = Menu_menucategory_mapping::whereIn('menu_category_id', $request->category)->get();
            $menu_ids = $menus_category->pluck('menu_id');
            $menus = Menu::whereIn('id', $menu_ids)->get();
        } else {
            $menus = Menu::all();
        }
        if($menus) {
            foreach($menus as $menu) {
                if($menu->photo){
                    $photo =  asset($menu->photo);
                } else {
                    $photo = 'https://previews.123rf.com/images/alexraths/alexraths1509/alexraths150900004/44625664-tarjeta-del-men%C3%BA-de-navidad-para-los-restaurantes-en-el-fondo-de-madera.jpg';
                }
                $output .= '<div class="menu-item bounceIn" id="'.$menu->id.'">';
                $output .= '<h3>'.$menu->name.'</h3>';    
                $output .= '<p><span class="taka_sign"> ৳ </span>'.$menu->price.'</p>';    
                $output .= '<img src="'.$photo.'" alt="">';
                $output .= '</div>';
            }
        }

        return $output;
        
    }
    
    public function findMenuitem(Request $request) 
    {
        $output = ''; 
        if($request->menu_search_item) {
            $menus = Menu::where('name', 'like', '%'.$request->menu_search_item.'%')->get();
        } else {
            $menus = Menu::all();
        }
        if($menus) {
            foreach($menus as $menu) {
                if($menu->photo){
                    $photo =  asset($menu->photo);
                } else {
                    $photo = 'https://previews.123rf.com/images/alexraths/alexraths1509/alexraths150900004/44625664-tarjeta-del-men%C3%BA-de-navidad-para-los-restaurantes-en-el-fondo-de-madera.jpg';
                }
                $output .= '<div class="menu-item bounceIn" id="'.$menu->id.'">';
                $output .= '<h3>'.$menu->name.'</h3>';    
                $output .= '<p><span class="taka_sign"> ৳ </span>'.$menu->price.'</p>';    
                $output .= '<img src="'.$photo.'" alt="">';
                $output .= '</div>';
            }
        }

        return $output;
        
    }

    //load notification
    public function loadNotification()
    {
        if(!Auth::user()->canDo(['manage_waiter','manage_cash'])) {
            return abort('401');
        }

        if(session()->has('previous_orders')) {
            
        } else {
            Session::put('previous_orders', 0);
        }

        $orders = Order::where('confirm_status', 1)->where('waiter_id', Auth::user()->id)->get();

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

        return view('waiter.notification')->with(array_merge($this->data, $data));
    }

    //confirm served
    public function orderServed(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = 1;
        $order->confirm_status = 2;
        $order->save();

        return ['type' => 'success', 'title' => 'Served', 'message' => 'Order has been servedd'];

    }

    //delete order

    public function destroy(Request $request, $id)
    {
//        if(Auth::user()->canDo('manage_admin')){
//            abort(401, 'Unauthorized Error');
//        }
        $order = Order::find($id);
//        $order_map = Order_menu_mapping::where('order_id',$id)->get();
        $order->deleted_by = \Auth::user()->email;
        $order->save();
//        $order_map->save();
        if ($order->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Order has been deleted successfully.'];
        }
    }

}
