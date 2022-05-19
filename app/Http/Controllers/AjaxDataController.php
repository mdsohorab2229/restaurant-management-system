<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\ProductCategory;
use App\Brand;
use App\Supplier;
use App\MenuCategory;
use App\ExpenseCategory;
use App\Table;
use App\Menu;
use App\Product;
use App\Stock;
use App\Ingredient_mapping;
use App\Kitchen_stock;
use App\Wasted_stock;
use App\Menu_menucategory_mapping;
use Datatables;
use Form;
use App\Order;
use App\Billing;
use DB;
use Auth;
use Carbon\Carbon;
use App\Discountcard;
use App\Buffetcar;
use App\Buffetincludecar;
use App\Expense;
use App\Supplier_ladger;
use App\Customerdiscount;
use App\Purchase_category;
use App\Purchase;
use App\Kitchen;
use App\KitchenChief;
use App\Product_price;
use App\Cash;
use App\CashCashier;
use App\Assetcategory;
use App\Asset;
use App\Banklist;
use App\Bankmoney;
use App\Bankloan;
use App\Investment;

class AjaxDataController extends Controller
{
    //
    public function index()
    {
        return 'what?';
    }

    public function getCustomerData()
    {
        $i = 1;
        $customers = Customer::select('id', 'name', 'phone', 'email', 'address');
        return Datatables::of($customers)
        ->addColumn('action', function($customer){
            return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$customer->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['customer.destroy', $customer->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
        })->addColumn('serial', function($customer) use(&$i){
            return $i++;
        })
        ->make(true);
    }

    //for Product Category
    public function getProductCategoryData()
    {
        $i = 1;
        $product_categories = ProductCategory::select('id', 'name');
        return Datatables::of($product_categories)
            ->addColumn('action', function($product_category){
                return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$product_category->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['product_category.destroy', $product_category->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($product_category) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for Brand
    public function getBrandData()
    {
        $i = 1;
        $brands = Brand::select('id', 'name');
        return Datatables::of($brands)
            ->addColumn('action', function($brand){
                return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$brand->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['brand.destroy', $brand->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($brand) use(&$i){
                return $i++;
            })
            ->make(true);
    }
    //for supplier
    public function getSupplierData()
    {
        $i = 1;
        $suppliers = Supplier::select('id', 'name', 'phone', 'email', 'address', 'status');
        return Datatables::of($suppliers)
            ->addColumn('action', function($supplier){
                return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$supplier->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['supplier.destroy', $supplier->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($supplier) use(&$i){
                return $i++;
            })
            ->make(true);
    }
    //menus category
    public function getMenuCategory()
    {
        $i = 1;
        $menu_categories = MenuCategory::select('id', 'name');
        return Datatables::of($menu_categories)
        ->addColumn('action', function($menu_category){
            return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$menu_category->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['menu_category.destroy', $menu_category->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
        })->addColumn('serial', function($menu_category) use(&$i){
            return $i++;
        })
        ->make(true);
    }

    //menus
    public function getMenuData()
    {
        $i = 1;
        $menus = Menu::with('kitchen');
        return Datatables::of($menus)
            ->addColumn('action', function($menu){
                return '<button class="btn btn-xs btn-primary view_data"   data-toggle="modal" data-target="#view_modal" id="'.$menu->id.'"><i class="fa fa-eye"></i> </button>
                <a href="'.route('menu.edit', $menu->id).'" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                '.Form::open(['route' => ['menu.destroy', $menu->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';

            })->addColumn('serial', function($menu) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //Expense category
    public function getExpenseCategory()
    {
        $i = 1;
        $categories = ExpenseCategory::select('id', 'name');
        return Datatables::of($categories)
        ->addColumn('action', function($category){
            return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$category->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['expense-category.destroy', $category->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
        })->addColumn('serial', function($category) use(&$i){
            return $i++;
        })
        ->make(true);
    }

    //Purchase category
    public function getPurchaseCategory()
    {
        $i = 1;
        $categories = Purchase_category::select('id', 'name');
        return Datatables::of($categories)
        ->addColumn('action', function($category){
            return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$category->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['purchase-category.destroy', $category->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
        })->addColumn('serial', function($category) use(&$i){
            return $i++;
        })
        ->make(true);
    }


     //Expense category
     public function getTable()
     {
         $i = 1;
         $tables = Table::select('id', 'name', 'nickname', 'capacity');
         return Datatables::of($tables)
         ->addColumn('action', function($table){
             return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$table->id.'"><i class="fa fa-edit"></i> </button>
             '.Form::open(['route' => ['table.destroy', $table->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
             ';
         })->addColumn('serial', function($table) use(&$i){
             return $i++;
         })
         ->make(true);
     }

     public function getProductData()
     {
        $i = 1;
        $products = Product::with(['brand', 'category', 'supplier', 'stock', 'stock.unit'])->orderBy('id', 'DESC');

        return Datatables::of($products)
        ->addColumn('action', function($product){
            return '<a class="btn btn-xs btn-primary edit_data" href="'.route('product.edit', $product->id).'"><i class="fa fa-edit"></i></a>
            '.Form::open(['route' => ['product.destroy', $product->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
        })
        ->addColumn('price', function($product) {
            return $product->stock->quantity*$product->cost;
        })
        ->addColumn('serial', function($product) use(&$i){
            return $i++;
        })
        ->make(true);
     }

     public function getRequestProductData()
     {
        $i = 1;
        $product_requests = Product_price::with(['product', 'product.stock.unit', 'product.supplier'])->where('status', 0);
        if(Auth::user()->canDo('manage_admin')) {
            $product_requests = $product_requests->get();
        }
        else if(Auth::user()->canDo('manage_store')) {
            $product_requests = $product_requests->where('created_by', Auth::user()->id)->get();
        }


        return Datatables::of($product_requests)
        ->addColumn('action', function($product_request){
            if(Auth::user()->canDo('manage_admin')){
                return ''.Form::open(['route' => ['product.request.approved', $product_request->id], 'method' => 'POST', 'class'=>'inline-el']).'<button type="submit" class="btn btn-success btn-xs" onclick="confirmSwal(this, event)" data-toggle="tooltip"> <i class="fa fa-check"></i> </button>'.Form::close().' 
                '.Form::open(['route' => ['product.request.canceled', $product_request->id], 'method' => 'POST', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="confirmSwal(this, event)" data-toggle="tooltip"> <i class="fa fa-trash"></i> </button>'.Form::close().'';
            }
            else if (Auth::user()->canDo('manage_store')) {
                return 'Pending';
            }
        })
        ->addColumn('serial', function($product_request) use(&$i){
            return $i++;
        })
        ->make(true);
     }

     public function getCanceldProductData()
     {
        $i = 1;
        $product_requests = Product_price::with(['product', 'product.stock.unit', 'product.supplier'])->where('status', 2);
        if(Auth::user()->canDo('manage_admin')) {
            $product_requests = $product_requests->get();
        }
        else if(Auth::user()->canDo('manage_store')) {
            $product_requests = $product_requests->where('created_by', Auth::user()->id)->get();
        }


        return Datatables::of($product_requests)
        ->addColumn('action', function($product_request){
            if(Auth::user()->canDo('manage_admin')){
                return ''.Form::open(['route' => ['product.request.approved', $product_request->id], 'method' => 'POST', 'class'=>'inline-el']).'<button type="submit" class="btn btn-success btn-xs" onclick="confirmSwal(this, event)" data-toggle="tooltip"> <i class="fa fa-check"></i> </button>'.Form::close().' 
                '.Form::open(['route' => ['product.request.canceled', $product_request->id], 'method' => 'POST', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="confirmSwal(this, event)" data-toggle="tooltip"> <i class="fa fa-trash"></i> </button>'.Form::close().'';
            }
            else if (Auth::user()->canDo('manage_store')) {
                return 'Pending';
            }
        })
        ->addColumn('serial', function($product_request) use(&$i){
            return $i++;
        })
        ->make(true);
     }

     public function getProductQuantity(Request $request)
     {
         $data = [
             'quantity' => 0,
             'unit'
         ];
        $product = Product::find($request->product_id);
        if($product) {
            $data = [
                'quantity' => $product->stock->quantity,
                'unit'     => $product->stock->unit->name
            ];

            
        }
        return $data;
     }

     //waiter order display
    public function getOrderData()
    {
        $i = 1;
        $orders = Order::where('waiter_id', Auth::user()->id)->where(DB::raw('date(created_at)'), Carbon::today())->with(['table']);
        return Datatables::of($orders)
            ->addColumn('action', function($order){
                if($order->status==2) {
                    $action = '';
                }else {
                    $action ='';
                    if(Auth::user()->canDo(['manage_admin','manage_cash'])) {
                        $action .= '<a href="'. route('order.edit', $order->id) .'" class="btn btn-xs btn-warning edit_data" id="'.$order->id.'"><i class="fa fa-edit"></i></a>';
                    }
                    $action .= '<a href="'. route('waiter.extra-order', $order->id) .'" class="btn btn-xs btn-info edit_data" id="'.$order->id.'"><i class="fa fa-plus"></i> Extra Order</a>';
                }

                return '<button class="btn btn-xs btn-primary view_data" data-toggle="modal" data-target="#view_modal" id="'.$order->id.'" data-order-no="'.$order->order_no.'"><i class="fa fa-eye"></i> </button>
                '.$action.'
            
            ';
            })->addColumn('serial', function($order) use(&$i){
                return $i++;
            })
            ->make(true);
    }
//'.Form::open(['route' => ['order.destroy', $order->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" data-placement="top" title="Cancel Order"> <i class="fa fa-times"></i> </button>'.Form::close().'
    //order display in Casear table
    public function getOrderDataForBilling()
    {
        $i = 1;
        if(Auth::user()->canDo(['manage_admin','manage_cash'])) {
            $orders = Order::with(['table','user'])->orderBy('id','desc')->whereDate('created_at', Carbon::today())->get();
        } 
        else if(Auth::user()->canDo('manage_jannat')) {
            $hide = getHideVal();
            if($hide==null) {
                $hide =100;
            }
            if($hide){
                $orders = Order::with(['table','user'])->whereDate('created_at', Carbon::today())->where('status', 2)->orderBy('id', 'DESC')->get();
                $count = count($orders);
                $target = ceil($count*($hide/100));
                $complete_orders = $orders->take($target);
            }
            $pendings = Order::with(['table','user'])->whereDate('created_at', Carbon::today())->where('status', '<>', 2)->orWhere('status', 0)->orWhere('status', 1)->orderBy('id', 'DESC')->get();
            
            $orders = $pendings->merge($complete_orders);
        }

        return Datatables::of($orders)
            ->addColumn('action', function($order){
                if($order->status==2)
                {
                $withoutpayment= '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$order->id.'" data-order-no="'.$order->order_no.'"><i class="fa fa-eye"></i> </button>';

                return $withoutpayment;  
                } 
                else if($order->status==0){
                    if(Auth::user()->canDo('manage_admin')) {
                        $withpayment= '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$order->id.'" data-order-no="'.$order->order_no.'"><i class="fa fa-eye"></i> </button>

                        <a href="'.route('order.print_view', $order->id).'" target="_blank" class="btn btn-xs btn-primary view_pdf" title="make pdf"><i class="fa fa-print"></i> </a>
                      
                        '.Form::open(['route' => ['billing.order.destroy', $order->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" title="Delete Order" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'';
                    }
                    else if (Auth::user()->canDo('manage_cash')) {
                        $withpayment= '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$order->id.'" data-order-no="'.$order->order_no.'"><i class="fa fa-eye"></i> </button>
                        <a href="'.route('order.print_view', $order->id).'" target="_blank" class="btn btn-xs btn-primary view_pdf" title="make pdf"><i class="fa fa-print"></i> </a>';
                    }

                    return $withpayment; 
                }
                else{
                    if(Auth::user()->canDo('manage_admin')) {
                        $withpayment= '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$order->id.'" data-order-no="'.$order->order_no.'"><i class="fa fa-eye"></i> </button>
                        <a href="'.route('order.print_view', $order->id).'" target="_blank" class="btn btn-xs btn-primary view_pdf" title="make pdf"><i class="fa fa-print"></i> </a>
                        
                        <button class="btn btn-xs btn-primary make_payment" title="make Payment" data-toggle="modal" data-target="#make_payment" id="'.$order->id.'" data-order-no="'.$order->order_no.'"><i class="fa fa-money"></i> </button>

                        <a href="'. route('order.extra-order', $order->id) .'" class="btn btn-xs btn-info edit_data" id="'.$order->id.'" target="_blank"><i class="fa fa-plus"></i> Extra Order</a>
                      
                        '.Form::open(['route' => ['billing.order.destroy', $order->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" title="Delete Order" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'';
                    }
                    else if (Auth::user()->canDo('manage_cash')) {
                        $withpayment= '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$order->id.'" data-order-no="'.$order->order_no.'"><i class="fa fa-eye"></i> </button>
                        <a href="'.route('order.print_view', $order->id).'" target="_blank" class="btn btn-xs btn-primary view_pdf" title="make pdf"><i class="fa fa-print"></i> </a>
                        
                        <button class="btn btn-xs btn-primary make_payment" title="make Payment" data-toggle="modal" data-target="#make_payment" id="'.$order->id.'" data-order-no="'.$order->order_no.'"><i class="fa fa-money"></i> </button>

                        <a href="'. route('order.extra-order', $order->id) .'" class="btn btn-xs btn-info edit_data" id="'.$order->id.'" target="_blank"><i class="fa fa-plus"></i> Extra Order</a>';
                    }                    

                    return $withpayment; 
                }   
            })->addColumn('serial', function($order) use(&$i){
                return $i++;
            })
            ->make(true);
    }
    // bill and order display in Billings page
    public function getdata_billingpage()
    {
        $i = 1;
        if(Auth::user()->canDo(['manage_admin','super_admin'])) {
            $billings = Billing::with(['customer', 'order', 'order.user'])->orderBy('id','desc');

        }
        else if(Auth::user()->canDo('manage_cash')) {
            $billings = Billing::with(['customer', 'order', 'order.user'])->orderBy('id','desc')->whereDate('created_at', Carbon::today())->get();

        }
        else if(Auth::user()->canDo('manage_jannat')) {
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
            $billings = Billing::with(['customer', 'order', 'order.user'])->whereIn('order_id', $order_ids)->orderBy('id', 'desc');
        }
        
        
        return Datatables::of($billings)
            ->addColumn('action', function($billing){
                if(Auth::user()->canDo('manage_admin')){
                    return '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$billing->order->id.'" data-order-no="'.$billing->order->order_no.'"><i class="fa fa-eye"></i> </button>
                        
                        <a href="'.route('billing.print_view', $billing->order->id).'" target="_blank" id="example2" class="btn btn-xs btn-primary view_pdf" title="make pdf" data-order-no="'.$billing->order_no.'"><i class="fa fa-print"></i> </a>
            '.Form::open(['route' => ['billing.billing.destroy', $billing->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" title="Delete Order" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
                }
           else if(Auth::user()->canDo('manage_cash')) {
                    return '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$billing->order->id.'" data-order-no="'.$billing->order->order_no.'"><i class="fa fa-eye"></i> </button>
                        
                        <a href="'.route('billing.print_view', $billing->order->id).'" target="_blank" id="example2" class="btn btn-xs btn-primary view_pdf" title="make pdf" data-order-no="'.$billing->order_no.'"><i class="fa fa-print"></i> </a>';
                }
            })->addColumn('serial', function($order) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //display all data in billing page

    // bill and order display in Billings page
    public function getalldata_billingpage()
    {
        $i = 1;
        if(Auth::user()->canDo('manage_admin')) {
            $billings = Billing::with(['customer', 'order', 'order.user']);

        }
        else if(Auth::user()->canDo('manage_cash')) {
            $billings = Billing::with(['customer', 'order', 'order.user'])->orderBy('id','desc')->where('created_by',Auth::user()->email)->get();

        }
        else if(Auth::user()->canDo('manage_jannat')) {
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
            $billings = Billing::with(['customer', 'order', 'order.user'])->whereIn('order_id', $order_ids);
        }


        return Datatables::of($billings)
            ->addColumn('action', function($billing){
                if(Auth::user()->canDo('manage_admin')){
                    return '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$billing->order->id.'" data-order-no="'.$billing->order->order_no.'"><i class="fa fa-eye"></i> </button>
                        
                        <a href="'.route('billing.print_view', $billing->order->id).'" target="_blank" id="example2" class="btn btn-xs btn-primary view_pdf" title="make pdf" data-order-no="'.$billing->order_no.'"><i class="fa fa-print"></i> </a>
            '.Form::open(['route' => ['billing.billing.destroy', $billing->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" title="Delete Order" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
                }else if (Auth::user()->canDo('manage_cash')) {
                    return '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$billing->order->id.'" data-order-no="'.$billing->order->order_no.'"><i class="fa fa-eye"></i> </button>
                        
                        <a href="'.route('billing.print_view', $billing->order->id).'" target="_blank" id="example2" class="btn btn-xs btn-primary view_pdf" title="make pdf" data-order-no="'.$billing->order_no.'"><i class="fa fa-print"></i> </a>';
                }
            })->addColumn('serial', function($order) use(&$i){
                return $i++;
            })
            ->make(true);
    }

     public function getkitchenQuantity(Request $request)
     {
         $data = [
             'quantity' => 0,
             'unit'
         ];
        $product = Product::find($request->product_id);
        if($product) {
            $data = [
                'quantity' => $product->kitchen->quantity,
                'unit'     => $product->stock->unit->name
            ];


        }
        return $data;
     }

     public function getKitchenStock()
     {
        $i = 1;
        $products = Kitchen_stock::with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC');
         return Datatables::of($products)
        ->addColumn('action', function($product){
            return '<a class="btn btn-xs btn-primary edit_data" href="'.route('product.edit', $product->id).'"><i class="fa fa-edit"></i></a>
            '.Form::open(['route' => ['product.destroy', $product->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
        })
        ->addColumn('serial', function($product) use(&$i){
            return $i++;
        })
        ->addColumn('price', function($product) {
            return $product->quantity*$product->product->cost;
        })
        ->make(true);
     }

     public function getWastedProduct()
     {
        $i = 1;
        $products = Wasted_stock::with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC');

        return Datatables::of($products)
        ->addColumn('price', function($product) {
            return $product->quantity*$product->product->cost;
        })
        ->addColumn('serial', function($product) use(&$i){
            return $i++;
        })
        ->make(true);
    }

    //for discount card
     public function getDiscountcardData()
     {
         $i = 1;
         $discountcards = Discountcard::with('customer');
         return Datatables::of($discountcards)
             ->addColumn('action', function($discountcard){
                 return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$discountcard->id.'"><i class="fa fa-edit"></i> </button>
             '.Form::open(['route' => ['discountcard.destroy', $discountcard->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
             ';
             })->addColumn('serial', function($discountcard) use(&$i){
                 return $i++;
             })
             ->make(true);
     }

    //for discount card for Customer
    public function getDiscountcustomerData()
    {
        $i = 1;
        $discountcardcustomers = Customerdiscount::with(['customer','discountcard']);
        return Datatables::of($discountcardcustomers)
            ->addColumn('action', function($discountcardcustomer){
                return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$discountcardcustomer->id.'"><i class="fa fa-edit"></i> </button>
             '.Form::open(['route' => ['discountcard.discountcustomerdestroy', $discountcardcustomer->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
             ';
            })->addColumn('serial', function($discountcardcustomers) use(&$i){
                return $i++;
            })
            ->make(true);
    }

     //for add car Company
     public function getBuffetcarsData()
     {
         $i = 1;
         $cars = Buffetcar::all();
         return Datatables::of($cars)
             ->addColumn('action', function($car){
                 return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$car->id.'"><i class="fa fa-edit"></i> </button>
             '.Form::open(['route' => ['buffetcars.destroy', $car->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
             ';
             })->addColumn('serial', function($car) use(&$i){
                 return $i++;
             })
             ->make(true);
     }

     //for buffet add car Company
     public function getBuffetData()
     {
         $i = 1;
         $buffets = Buffetincludecar::with(['buffetcar']);
         return Datatables::of($buffets)
             ->addColumn('action', function($buffet){
                 return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$buffet->id.'"><i class="fa fa-edit"></i> </button>
             '.Form::open(['route' => ['buffetcars.buffetdestroy', $buffet->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
             ';
             })->addColumn('serial', function($buffet) use(&$i){
                 return $i++;
             })
             ->make(true);
     }


    public function getExpenseData()
    {
        $i = 1;
        $expenses = Expense::with('expenseCategory')->orderBy('id', 'desc');
        return Datatables::of($expenses)
        ->addColumn('action', function($expense){
            return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$expense->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['expense.destroy', $expense->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
        })->addColumn('expense_category', function($expense){
            if($expense->expenseCategory) {
                return $expense->expenseCategory->name;
            } else {
                return '';
            }
        })->addColumn('serial', function($expense) use(&$i){
            return $i++;
        })
        ->make(true);
    }

    public function getPurchaseData()
    {
        $i = 1;
        $purchases = Purchase::with('purchaseCategory')->orderBy('id', 'desc');
        return Datatables::of($purchases)
        ->addColumn('action', function($purchase){
            return '<button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$purchase->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['purchase.destroy', $purchase->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
        })->addColumn('purchase_category', function($purchase){
            if($purchase->purchaseCategory) {
                return $purchase->purchaseCategory->name;
            } else {
                return '';
            }
        })->addColumn('serial', function($purchase) use(&$i){
            return $i++;
        })
        ->make(true);
    }

    public function getSupplierLedger()
    {
        $i = 1;
        $ledgers = Supplier_ladger::with('supplier')->orderBy('id', 'desc');
        return Datatables::of($ledgers)
        ->addColumn('action', function($ledger){
            return '<a href="" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
            <button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$ledger->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['supplier-ledger.destroy', $ledger->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
        })->addColumn('serial', function($ledger) use(&$i){
            return $i++;
        })
        ->make(true);
    }

    //for kitchen

    public function getKitchenData()
    {
        $i = 1;
        $kitchens = Kitchen::all();
        return Datatables::of($kitchens)
            ->addColumn('action', function($kitchen){
                return '
            <button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$kitchen->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['kitchen.destroy', $kitchen->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for kitchen and chief

    public function getKitchenChiefData()
    {
        $i = 1;
        $kitchenchiefs = KitchenChief::with(['user','kitchen']);
        return Datatables::of($kitchenchiefs)
            ->addColumn('action', function($kitchenchief){
                return '
            <button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$kitchenchief->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['kitchenchief.destroy', $kitchenchief->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for cash

    public function getCashData()
    {
        $i = 1;
        $cashes = Cash::all();
        return Datatables::of($cashes)
            ->addColumn('action', function($cash){
                return '
            <button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$cash->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['cash.destroy', $cash->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for cash & Cashier
    public function getCashCashierData()
    {
        $i = 1;
        $cashcashiers = CashCashier::with(['user','cash']);
        return Datatables::of($cashcashiers)
            ->addColumn('action', function($cashcashier){
                return '
            <button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$cashcashier->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['cashcashier.destroy', $cashcashier->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for cash & Cashier
    public function getAssetCategoryData()
    {
        $i = 1;
        $assetcategories = Assetcategory::all();
        return Datatables::of($assetcategories)
            ->addColumn('action', function($assetcategory){
                return '
            <button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$assetcategory->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['asset.destroy', $assetcategory->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for cash & Cashier
    public function getAssetData()
    {
        $i = 1;
        $assets = Asset::with(['assetcategory']);
        return Datatables::of($assets)
            ->addColumn('action', function($asset){
                return '
            <button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#edit_modal" id="'.$asset->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['assetlist.destroy', $asset->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for banklist
    public function getBanklistData()
    {
        $i = 1;
        $banklists = Banklist::all();
        return Datatables::of($banklists)
            ->addColumn('action', function($banklist){
                return '
            <button class="btn btn-xs btn-primary edit_data" data-toggle="modal" data-target="#edit_modal" id="'.$banklist->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['banklist.destroy', $banklist->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for bankcategory
    public function getBankCategoryData()
    {
        $i = 1;
        $categories = Bankcategory::all();
        return Datatables::of($categories)
            ->addColumn('action', function($category){
                return '
            <button class="btn btn-xs btn-primary edit_data" data-toggle="modal" data-target="#edit_modal" id="'.$category->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['bankcategory.destroy', $category->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for bankmoney
    public function getBankMoneyData()
    {
        $i = 1;
        $bankmones = Bankmoney::with(['banklist'])->orderBy('id', 'desc');
        return Datatables::of($bankmones)
            ->addColumn('action', function($bankmone){
                return '
            <button class="btn btn-xs btn-primary edit_data" data-toggle="modal" data-target="#edit_modal" id="'.$bankmone->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['bankmoney.destroy', $bankmone->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for bankloan
    public function getBankloanMoneyData()
    {
        $i = 1;
        $bankloans = Bankloan::with(['banklist'])->orderBy('id', 'desc');
        return Datatables::of($bankloans)
            ->addColumn('action', function($bankloan){
                return '
            <button class="btn btn-xs btn-primary edit_data" data-toggle="modal" data-target="#edit_modal" id="'.$bankloan->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['bankloan.destroy', $bankloan->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

    //for investment Capital
    public function getInvestmentData()
    {
        $i = 1;
        $investments = Investment::all();
        return Datatables::of($investments)
            ->addColumn('action', function($investment){
                return '
            <button class="btn btn-xs btn-primary edit_data" data-toggle="modal" data-target="#edit_modal" id="'.$investment->id.'"><i class="fa fa-edit"></i> </button>
            '.Form::open(['route' => ['bankloan.destroy', $investment->id], 'method' => 'DELETE', 'class'=>'inline-el']).'<button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>'.Form::close().'
            ';
            })->addColumn('serial', function($ledger) use(&$i){
                return $i++;
            })
            ->make(true);
    }

}
