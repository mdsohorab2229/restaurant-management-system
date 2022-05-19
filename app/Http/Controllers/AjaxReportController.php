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
use App\Order_menu_mapping;
use App\Billing;
use Auth;
use Carbon\Carbon;

class AjaxReportController extends Controller
{
    //get product
    public function getProduct()
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

    //get product
    public function getWastedProduct()
     {
        $i = 1;
        $wasteds = Wasted_stock::with(['product', 'product.brand', 'product.category', 'product.supplier','product.stock', 'product.stock.unit'])->orderBy('id', 'DESC');

        return Datatables::of($wasteds)
            ->addColumn('price', function($product) {
                return $product->quantity*$product->product->cost;
            })
        ->addColumn('serial', function($wasted) use(&$i){
            return $i++;
        })
        ->make(true);
     }


     public function getInvoice()
     {
        $i = 1;
        $invoices = Billing::with(['order']);

        return Datatables::of($invoices)
        ->addColumn('action', function($invoice){
            return '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$invoice->id.'" data-order-no="'.$invoice->order_no.'"><i class="fa fa-eye"></i> </button>
            <a href="'.route('billing.printpriview', $invoice->order->id).'" target="_blank" class="btn btn-xs btn-primary view_pdf" title="Show Invoice" data-order-no="'.$invoice->order_no.'"><i class="fa fa-print"></i> </a>
            ';
        })
        ->addColumn('serial', function($invoice) use(&$i){
            return $i++;
        })
        ->make(true);
     }

    public function getCashierreport()
    {
        $i = 1;
        if(Auth::user()->canDo('manage_admin')) {
            $invoices = Billing::with(['order']);

        }
        else if(Auth::user()->canDo('manage_cash')) {
            $invoices = Billing::with(['order'])->where('created_by',Auth::user()->email)->get();
        }



        return Datatables::of($invoices)
            ->addColumn('action', function($invoice){
                return '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$invoice->id.'" data-order-no="'.$invoice->order_no.'"><i class="fa fa-eye"></i> </button>
            
            ';
            })
            ->addColumn('serial', function($invoice) use(&$i){
                return $i++;
            })

            ->make(true);
    }

    public function getKitchenReport()
    {
        $i = 1;
        if(Auth::user()->canDo('manage_admin')){
            $orders = Order::with(['user', 'chief', 'table'])->whereNotNull('chief_id')->where('status', 2)->orderBy('id', 'DESC')->get();
        } else if(Auth::user()->canDo('manage_chief')) {
            $orders = Order::with(['user', 'chief', 'table'])->whereDate('created_at', Carbon::today())->where('status', 2)->where('chief_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        return Datatables::of($orders)
            ->addColumn('action', function($order){
                return '<button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="'.$order->id.'" data-order-no="'.$order->order_no.'"><i class="fa fa-eye"></i> </button>
            ';
            })
            ->addColumn('serial', function($order) use(&$i){
                return $i++;
            })
            ->make(true);
    }



}
