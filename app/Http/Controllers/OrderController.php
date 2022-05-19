<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Menu;
use App\Order;
use App\Order_menu_mapping;
use Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use Response;
use DB;
use Carbon\Carbon;
use PDF;
use App\MenuCategory;
use App\Menu_menucategory_mapping;
use App\Setting;
class OrderController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Order List :: Jannat Restaurant & Resort',
            'page_header' => 'Order List',
            'page_desc' => '',
            'menus' => Menu::all(),
            'orders' => Order::all(),
        ];

        return view('menus.index')->with(array_merge($this->data,$data));
    }

    //store product
    public function store(Request $request)
    {
        $this->validate($request, [
            'kitchen_id' => 'required',
        ]);
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
            $order->table_id                 = $request->table_id;
            $order->kitchen_id                 = $request->kitchen_id;
            $order->sub_total                = $request->subtotal;
            $order->discount                 = $request->discount;
            $order->tax                      = $request->vat;
            $order->amount                   = $request->total;
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

            return ['type' => 'success', 'title' => 'Success!', 'redirect_newtab'  => route('order.token', $order->id), 'redirect' => route('waiter.dashboard'),  'message' => 'Order Successfully sent to ktichen'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to store Ordered'];
        }
    }

    //for order view
    public function view(Request $request)
    {
        $orders = Order::with('table')->find($request->order_id);
        $order_menu_mappinges =Order_menu_mapping::with('menu')->where('order_id',$request->order_id)->get();

        $output = '';
        if($order_menu_mappinges) {
            $output .= '<input type="hidden" name="order_no" value="'.$orders->order_no.'">';
            $output .= '<table class="table">';
            $output .= '<tr><th>Name</th><th>Quantity</th><th>Price</th></tr>';
            foreach($order_menu_mappinges as $key => $menu) {
                if($menu->type==1) {
                    $type = '<span class="label label-info">Extra</span>';
                } else  {
                    $type = '';
                }
                $output .= '<tr>';
                $output .= '<td>'.$menu->menu->name.' '.$type.'</span></td>';
                $output .= '<td>'.$menu->quantity.'</td>';
                $output .= '<td>'.$menu->price.'</td>';
                $output .= '</tr>';
            }
            $output .= '</table>';
            return $output;
        }

        return $output;
    }

    public function extraStore(Request $request)
    {
        try{
            DB::beginTransaction();
            //Order to Order Menu maping

            $order_menus= $request->menu_id;
            $quantities = $request->quantity;
            $prices = $request->menu_price;

            $order = Order::find($request->order_id);
            $order->sub_total = $order->sub_total + $request->subtotal;
            $order->tax = $order->tax + $request->vat;
            $order->amount = $order->amount + $request->total;
            $order->save();

            foreach ($order_menus as $key => $order_menu)
            {
                $extra_order = Order_menu_mapping::where('order_id', $order->id)->where('menu_id', $order_menu)->where('type', 1)->first();
                if($extra_order) {
                    $extra_order->quantity = $extra_order->quantity + $quantities[$key];
                    $extra_order->price = $extra_order->price + $prices[$key];
                    $extra_order->save();
                }
                else {
                    $order_menu_map = new Order_menu_mapping();
                    $order_menu_map->order_id = $request->order_id;
                    $order_menu_map->menu_id = $order_menu;
                    $order_menu_map->cost = Menu::find($order_menu) ? Menu::find($order_menu)->cost : 0;
                    $order_menu_map->sell_price = Menu::find($order_menu) ? Menu::find($order_menu)->price : 0;
                    $order_menu_map->quantity = $quantities[$key];
                    $order_menu_map->price = $prices[$key];
                    $order_menu_map->type= 1;
                    $order_menu_map->save();
                }

            }

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('waiter.dashboard'), 'message' => 'Extra Order Send Kitchen successfully'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to send order in kitchen'];
        }
    }

    public function menuView(Request $request)
    {
        $order = Order::find($request->order_id);
        $menus = Order_menu_mapping::where('order_id', $request->order_id)->get();
        
        $output = '';
        if($menus) {
            $output .= '<input type="hidden" name="order_id" value="'.$order->id.'">';
            $output .= '<table class="table">';
            $output .= '<tr><th>Name</th><th>Quantity</th><th>Price</th></tr>';
            foreach($menus as $key => $menu) {
                $output .= '<tr>';
                $output .= '<td>'.$menu->menu->name.'</td>';
                $output .= '<td>'.$menu->quantity.'</td>';
                $output .= '<td>'.$menu->price.'</td>';
                $output .= '</tr>';
            }
            $output .= '</table>';
            return $output;
        }
        
        return $output;

    }

    public function reorderMenuView(Request $request)
    {
        $order = Order::find($request->order_id);
        $menus = Order_menu_mapping::where('order_id', $request->order_id)->where('type', 1)->where('served_status', 0)->get();
        
        $output = '';
        if($menus) {
            $output .= '<input type="hidden" name="order_id" value="'.$order->id.'">';
            $output .= '<table class="table">';
            $output .= '<tr><th>Name</th><th>Quantity</th><th>Price</th></tr>';
            foreach($menus as $key => $menu) {
                $output .= '<tr>';
                $output .= '<td>'.$menu->menu->name.'</td>';
                $output .= '<td>'.$menu->quantity.'</td>';
                $output .= '<td>'.$menu->price.'</td>';
                $output .= '</tr>';
            }
            $output .= '</table>';
            return $output;
        }
        
        return $output;

    }

    // ModelName::groupBy('group_id')
// ->selectRaw('count(*) as total, group_id')
// ->get();

    //order_edit
    public function edit($id)
    {
        $order= Order::find($id);
        $ordered_menus = Order_menu_mapping::where('order_id', $id)
                ->groupBy('menu_id')
                ->selectRaw('menu_id')
                ->selectRaw('sum(price) as price')
                ->selectRaw('sum(quantity) as quantity')
                ->get();

        $data = [
            'page_title' => 'Menu Ordering',
            'page_header' => 'Menu Ordering',
            'page_desc' => '',
            'order' => $order,
            'menus' => Menu::all(),
            'menu_categories' => MenuCategory::all(),
            'order_menus' => $ordered_menus
        ];

        return view('order.edit')->with(array_merge($this->data, $data));
    }


    //update order
    public function update(Request $request, $id)
    {
        try{

            DB::beginTransaction();
            //make menu
            $order = Order::find($id);
            $order->sub_total                = $request->subtotal;
            $order->discount                 = $request->discount;
            $order->tax                      = 0;
            $order->amount                   = $request->total;
            $order->discount                 = $request->discount;
            $order->updated_by               = \Auth::user()->email;
            $order->save();

            //Order to Order Menu maping

            $order_menus= $request->menu_id;
            $quantities = $request->quantity;
            $prices = $request->menu_price;
            $order_menu_ids = Order_menu_mapping::where('order_id', $id)->get()->pluck('menu_id');
            $order_menu_ids = $order_menu_ids->flatten();
            $diff = $order_menu_ids->diff($order_menus);
            if($diff) {
                Order_menu_mapping::where('order_id', $order->id)->whereIn('menu_id', $diff)->delete();
            }

            foreach ($order_menus as $key => $order_menu)
            {
                //find menu of mapping to check its quantity
                $menu = Order_menu_mapping::where('order_id', $order->id)->where('menu_id', $order_menu)->where('type', 0)->first();
                $extra = Order_menu_mapping::where('order_id', $order->id)->where('menu_id', $order_menu)->where('type', 1)->first();
                
                if($menu && $menu->quantity >= $quantities[$key]) {
                    if($extra) {
                        $extra->delete();
                    }
                    $menu->quantity = $quantities[$key];
                    $menu->price = $prices[$key];
                    $menu->save();
                }
                else if($menu && $menu->quantity < $quantities[$key]) {
                    if($extra) {
                        $extra->quantity = $quantities[$key] - $menu->quantity;
                        $extra->price = $prices[$key] - $menu->price;
                        $extra->save();
                    } else {
                        $menu->quantity = $quantities[$key];
                        $menu->price = $prices[$key];
                        $menu->save();
                    }
                   
                }
                else if($extra) {
                    $extra->quantity = $quantities[$key];
                    $extra->price = $prices[$key];
                    $extra->save();
                } else {
                    $order_menu_map = new Order_menu_mapping();
                    $order_menu_map->order_id = $order->id;
                    $order_menu_map->menu_id = $order_menu;
                    $order_menu_map->quantity = $quantities[$key];
                    $order_menu_map->price = $prices[$key];                
                    $order_menu_map->type= 0;
                    $order_menu_map->save();
                }
                
            }

            DB::commit();

            return ['type' => 'success', 'title' => 'Updated!', 'redirect' => route('waiter.dashboard'), 'message' => 'Ordered Update Successfully'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Update Ordered'];
        }
    }

    public function extraOrder($id)
    {
        if(!Auth::user()->canDo(['manage_cash'])) {
            return abort('401');
        }

        $data = [
            'page_title' => 'Extra Order',
            'page_header' => 'Extra order',
            'page_desc' => '',
            'order_id' => $id,
            'settings' => Setting::first(),
            'menus' => Menu::all(),
            'menu_categories' => MenuCategory::all(),

        ];

        return view('cashier.extra-order')->with(array_merge($this->data, $data));
    }

    public function cashierExtraStore(Request $request)
    {
        try{
            DB::beginTransaction();
            //Order to Order Menu maping

            $order_menus= $request->menu_id;
            $quantities = $request->quantity;
            $prices = $request->menu_price;

            $order = Order::find($request->order_id);
            $order->sub_total = $order->sub_total + $request->subtoal;
            $order->tax = $order->tax + $request->vat;
            $order->amount = $order->amount + $request->total;
            $order->save();

            foreach ($order_menus as $key => $order_menu)
            {
                $extra_order = Order_menu_mapping::where('order_id', $order->id)->where('menu_id', $order_menu)->where('type', 1)->first();
                if($extra_order) {
                    $extra_order->quantity = $extra_order->quantity + $quantities[$key];
                    $extra_order->price = $extra_order->price + $prices[$key];
                    $extra_order->save();
                }
                else {
                    $order_menu_map = new Order_menu_mapping();
                    $order_menu_map->order_id = $request->order_id;
                    $order_menu_map->menu_id = $order_menu;
                    $order_menu_map->cost = Menu::find($order_menu) ? Menu::find($order_menu)->cost : 0;
                    $order_menu_map->sell_price = Menu::find($order_menu) ? Menu::find($order_menu)->price : 0;
                    $order_menu_map->quantity = $quantities[$key];
                    $order_menu_map->price = $prices[$key];
                    $order_menu_map->type= 1;
                    $order_menu_map->served_status = 1;
                    $order_menu_map->save();
                }

            }

            DB::commit();

            return ['type' => 'success', 'title' => 'Success!',  'message' => 'Extra Order Addedd successfully'];
        }
        catch(\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to add extra order'];
        }
    }



    
}
