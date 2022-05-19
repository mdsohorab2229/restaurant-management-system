<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order_menu_mapping;
use App\Order;
use App\Customer;
use App\Menu;
use App\Billing;
use PDF;
use DB;
use Carbon\Carbon;
use App\Setting;
use Auth;
class BillingController extends Controller
{
    public function index()
    {
        if(Auth::user()->canDo(['manage_admin', 'manage_cash']))
        {
            $orders = Order::where('status', 2)->get();
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
            }
        }

        $data = [
            'page_title'  => 'Order_list Panel',
            'page_header' => 'Order_list Panel',
            'page_desc'   => '',
            'orders'      => Order::all(),
            'order_menu_mappinges' => Order_menu_mapping::all(),
            'customers'   => Customer::all(),
            'total_order' => $orders,
            'ongoing_order' => Order::where('status', 1)->get(),
            'pending_order' => Order::where('status', 0)->get(),
        ];

        return view('billing.index')->with(array_merge($this->data, $data));
    }
    //for order view
    public function view(Request $request)
    {
        $orders = Order::with('table')->find($request->order_id);
        $order_menu_mappinges =Order_menu_mapping::with('menu')->where('order_id',$request->order_id)->get();
        $billings = Billing::where('order_id', $request->order_id)->first();
        $payable = $orders->amount - $orders->discount;
        $output = '';
        if($order_menu_mappinges) {
            $output .= '<input type="hidden" name="order_no" value="'.$orders->order_no.'">';
            $output .= '<table class="table">';
            $output .= '<tr><th>Name</th><th>Quantity</th><th>Price</th></tr>';
            foreach($order_menu_mappinges as $key => $menu) {
                if($menu->type==1) {
                    $extra = '<label class="label label-info">Extra</label>';
                } else {
                    $extra = '';
                }
                $output .= '<tr>';
                $output .= '<td>'.$menu->menu->name.' '.$extra.'</td>';
                $output .= '<td>'.$menu->quantity.'</td>';
                $output .= '<td>'.$menu->price.'</td>';

                $output .= '</tr>';
            }
            $output .='<tr>';
            $output .='<td></td>';
            $output .='<th>Sub Total</th>';
            $output .= '<th>'.$orders->sub_total.'</th>';
            $output .='</tr>';
            $output .='<tr>';
            $output .='<td></td>';
            $output .='<th>Vat</th>';
            $output .= '<th>'.$orders->tax.'</th>';
            $output .='</tr>';
            $output .='<tr>';
            $output .='<td></td>';
            $output .='<th>Discount</th>';
            $output .= '<th>'.$orders->discount.'</th>';
            $output .='</tr>';
            $output .='<tr>';
            $output .='<td></td>';
            $output .='<th>Payable</th>';
            $output .= '<th>'.$payable.'</th>';
            $output .='</tr>';
            if($billings) {
                $output .='<tr>';
                $output .='<td></td>';
                $output .='<th>Paid</th>';
                $output .= '<th>'.$billings->deposit.'</th>';
                $output .='</tr>';
                $output .='<tr>';
                $output .='<td></td>';
                $output .='<th>Due</th>';
                $output .= '<th>'.$billings->due.'</th>';
                $output .='</tr>';
            }
            $output .= '</table>';
            return $output;
        }

        return $output;
    }
    //for Delete data
    public function destroy(Request $request, $id)
    {

        $order = Order::find($id);
        $order_mapping = Order_menu_mapping::where('order_id', $id)->delete();
        //$order->deleted_by = \Auth::user()->email;
        //$order->save();
        if ($order->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Order has been deleted successfully.'];
        }
    }
    //display order for billing
    public function make_payment(Request $request)
    {
        $setting = Setting::first();
        $orders = Order::with('table')->find($request->order_id);
        $order_menu_mappinges =Order_menu_mapping::with('menu')->where('order_id',$request->order_id)->get();
        $total_amount = $orders->amount;
        $default_discount = 0;
        if($setting->discount_switch != null){
            if($setting->discount_type == 0) {
                $default_discount = $orders->amount - $setting->discount;
            } else if ($setting->discount_type == 1) {
                $default_discount = $orders->amount * ($setting->discount / 100) ;
            }
        }

        $vat_amount = 0;        
        if($setting->tax_switch != null){
//            $vat_amount = $orders->amount * ($setting->tax / 100);
//            if($setting->tax_type == 0) { // 0 for inclusive, 1exlusive
//                $total_amount = $orders->amount - $vat_amount;
//            } else if ($setting->tax_type == 1) {
//                $total_amount = $orders->amount + $vat_amount;
//            }
            $total_amount = $orders->amount;

        }



        $output = '';
        $quantity = 0;
        $total = 0;
        $data = [];
        $data ['default_discount'] = $default_discount;
        $data ['due'] = $orders->amount - $default_discount;
        if($order_menu_mappinges) {
            foreach($order_menu_mappinges as $key => $menu) {
                $quantity += $menu->quantity;
                $cost = $menu->cost*$menu->quantity;
                $profit = $menu->price - $cost;
                $total += $profit;
            }
            $output .= '<input type="hidden" name="profit" value="'.$total.'">';
            $output .= '<input type="hidden" name="order_no" value="'.$orders->order_no.'">';
            $output .= '<table class="table">';
            $output .='<tr>';
            $output .='<td></td>';
            $output .='<th>SubTotal</th>';
            $output .= '<th>'.$setting->currency_prefix.' '.$orders->sub_total.' '.$setting->currency_suffix.'</th>';
            $output .='</tr>';
            $output .='<tr>';
            $output .='<td></td>';
            $output .='<th>Vat</th>';
            $output .= '<th>'.$setting->currency_prefix.' '.$orders->tax.' '.$setting->currency_suffix.'</th>';
            $output .='</tr>';
            $output .='<tr>';
            $output .='<td></td>';
            $output .='<th>Discount</th>';
            $output .= '<th><span id="show_discount_amount">0</span></th>';
            $output .='</tr>';
            $output .='<tr>';
            $output .='<td></td>';
            $output .='<th>Grand Amount</th>';
            $output .= '<th>'.$setting->currency_prefix.' '.$total_amount.' '.$setting->currency_suffix.'<input type="hidden" value="'.$total_amount.'" id="total_amount"></th>';
            $output .='</tr>';
            $output .='<tr>';
            $output .='<td></td>';
            $output .='<th>Total Quantity</th>';
            $output .= '<th>'.$quantity.'</th>';
            $output .='</tr>';
            $output .= '</table>';
            $output .='<input type="hidden" name="order_id" value='.$orders->id.'>';
            $output .='<input type="hidden" name="amount" id="remainingval" onkeyup="forDue()" value='.$orders->amount.'>';
            $data['output'] = $output;
        }

        return $data;
    }

    //store bill in database
    public function create(Request $request)
    {

        $this->validate($request, [
            'customer' => 'required',
            'deposit' => 'required',
            'deposit_type' => 'required',
        ]);
        try{

        DB::beginTransaction();
        //order status change

        $order = Order::find($request->order_id);
        $order->discount = $request->discount;
        $order->status = 2;
        $order->save();

        $billing = new Billing();
        $billing->customer_id   = $request->customer;
        $billing->order_id      = $request->order_id;
        $billing->deposit       = $request->deposit;
        $billing->type          = $request->deposit_type;
        $billing->transaction   = $request->transaction;
        $billing->card          = $request->card;
        $billing->due           = $request->due;
        $billing->profit        = $request->profit;
        $billing->created_by    = \Auth::user()->email;
        $billing->save();
        DB::commit();
        return ['type' => 'success', 'title' => 'Success!', 'redirect_newtab'  => route('billing.print_view', $billing->order_id) ,'message' => 'Bill Add Successfully'];
    }
    catch(\Throwable $e) {
        dd($e->getMessage());
        DB::rollBack();
        return ['type' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Store Brand Category Successfully'];
    }
}

    //billing list page

    //index billing_list display
    public function billing_index()
    {
        if(Auth::user()->canDo(['manage_admin', 'manage_cash'])) {
            $data = [
                'page_title'  => 'Billing_list Panel',
                'page_header' => 'Billing_list Panel',
                'page_desc'   => '',
                'orders'      => Order::all(),
                'order_menu_mappinges' => Order_menu_mapping::all(),
                'customers'   => Customer::all(),
                'total_profit' => Billing::sum('profit'),
                'total_sell' => Order::where('status', 2)->get(),
                'today_profit' => Billing::where('created_at', Carbon::today())->sum('profit'),
                'today_sell' => Order::where('status', 2)->where('created_at', Carbon::today())->get(),
            ];
        }
        else if(Auth::user()->canDo(['manage_jannat'])) {
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
            
            $data = [
                'page_title'  => 'Billing_list Panel',
                'page_header' => 'Billing_list Panel',
                'page_desc'   => '',
                'orders'      => $orders,
                'order_menu_mappinges' => Order_menu_mapping::all(),
                'customers'   => Customer::all(),
                'total_profit' => Billing::whereIn('order_id', $order_ids)->sum('profit'),
                'total_sell' => Order::whereIn('id', $order_ids)->where('status', 2)->get(),
                'today_profit' => Billing::where('created_at', Carbon::today())->sum('profit'),
                'today_sell' => Order::where('status', 2)->where('created_at', Carbon::today())->get(),
            ];
        }
        return view('billing.billing_list')->with(array_merge($this->data, $data));
    }

    //for all billing

    //index billing_list display
    public function all_billing_index()
    {
        if(Auth::user()->canDo(['manage_admin', 'manage_cash'])) {
            $data = [
                'page_title'  => 'All Billing_list Panel',
                'page_header' => 'All Billing_list Panel',
                'page_desc'   => '',
                'orders'      => Order::all(),
                'order_menu_mappinges' => Order_menu_mapping::all(),
                'customers'   => Customer::all(),
                'total_profit' => Billing::sum('profit'),
                'total_sell' => Order::where('status', 2)->get(),
                'today_profit' => Billing::where('created_at', Carbon::today())->sum('profit'),
                'today_sell' => Order::where('status', 2)->where('created_at', Carbon::today())->get(),
            ];
        }
        else if(Auth::user()->canDo(['manage_jannat'])) {
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

            $data = [
                'page_title'  => 'Billing_list Panel',
                'page_header' => 'Billing_list Panel',
                'page_desc'   => '',
                'orders'      => $orders,
                'order_menu_mappinges' => Order_menu_mapping::all(),
                'customers'   => Customer::all(),
                'total_profit' => Billing::whereIn('order_id', $order_ids)->sum('profit'),
                'total_sell' => Order::whereIn('id', $order_ids)->where('status', 2)->get(),
                'today_profit' => Billing::where('created_at', Carbon::today())->sum('profit'),
                'today_sell' => Order::where('status', 2)->where('created_at', Carbon::today())->get(),
            ];
        }
        return view('billing.all_billing_list')->with(array_merge($this->data, $data));
    }

    //delete billing 
    public function destroyBilling(Request $request, $billing_id)
    {
        
        $billing = Billing::find($billing_id);
        $billing->deleted_by = \Auth::user()->email;
        $billing->save();
        if ($billing->delete()) {
            return ['type' => 'success', 'title' => 'Deleted!', 'message' => 'Billing has been deleted successfully.'];
        }
    }

    //for pdf
    public function pdf_view() 
	{
		$data = [
            'page_header' => 'Jannat Restaurant & Resort',
            'address'     => 'Address',
            'about' => 'Cash Bill',
		];
		$pdf = PDF::loadView('pdf.document', $data);
		return $pdf->stream('document.pdf');
	}
}
