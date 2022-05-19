<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Brand;
use App\Customer;
use App\ProductCategory;
use App\Supplier;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    //
    protected $settings_key = [
        'restaurant_name', 'phone', 'email', 'restaurant_address', 'default_category', 'default_brand', 'default_customer', 'default_supplier', 'currency_code', 'currency_prefix', 'currency_suffix','default_discount', 'default_discount_type', 'default_tax', 'default_tax_type', 'invoice_header', 'invoice_footer'
    ];

    public function index()
    {
        $setting = Setting::first();
        
        $data = [
            'page_title'  => 'Software Settings Setting',
            'page_header' => 'Software Settings',
            'page_desc'  => '',
            'setting'    => $setting,
            'categories' => ProductCategory::all(),
            'brands'     => Brand::all(),
            'suppliers'  => Supplier::all(),
            'customers'  => Customer::all()
        ];

        return view('settings.index')->with(array_merge($this->data, $data));
    }



    public function update(Request $request)
    {
        $setting = Setting::first();
        if($setting)
        {
            $setting->restaurant_name = $request->res;
            $setting->restaurant_name = $request->restaurant_name;
            $setting->phone = $request->phone;
            $setting->email = $request->email;
            $setting->address = $request->address;
            $setting->category_id = $request->default_category;
            $setting->customer_id = $request->default_customer;
            $setting->supplier_id = $request->default_supplier;
            $setting->brand_id = $request->default_brand;
            $setting->currency_code = $request->currency_code;
            $setting->currency_suffix = $request->currency_suffix;
            $setting->currency_prefix = $request->currency_prefix;
            $setting->discount = $request->discount;
            $setting->discount_type = $request->discount_type;
            $setting->discount_switch = $request->discount_on_off ? $request->discount_on_off : null;
            $setting->tax = $request->tax;
            $setting->tax_type = $request->tax_type;
            $setting->tax_switch = $request->tax_on_off ? $request->tax_on_off : null;
            $setting->updated_by = \Auth::user()->email;
            $setting->save();

            return ['type' => 'success', 'title' => 'Updated!', 'redirect' => route('site.settings'), 'message' => 'Settings have been updated successfully.'];
        }   
        
        $setting = new Setting();
        $setting->restaurant_name = $request->restaurant_name;
        $setting->phone = $request->phone;
        $setting->email = $request->email;
        $setting->address = $request->address;
        $setting->category_id = $request->default_category;
        $setting->customer_id = $request->default_customer;
        $setting->supplier_id = $request->default_supplier;
        $setting->brand_id = $request->default_brand;
        $setting->currency_code = $request->currency_code;
        $setting->currency_suffix = $request->currency_suffix;
        $setting->currency_prefix = $request->currency_prefix;
        $setting->discount = $request->discount;
        $setting->discount_type = $request->discount_type;
        $setting->discount_switch = $request->discount_on_off ? $request->discount_on_off : null;
        $setting->tax = $request->tax;
        $setting->tax_type = $request->tax_type;
        $setting->tax_switch = $request->tax_on_off ? $request->tax_on_off : null;
        $setting->created_by = \Auth::user()->email;
        $setting->save();

        return ['type' => 'success', 'title' => 'Success!', 'redirect' => route('site.settings'), 'message' => 'Software Settings has been saved.'];
    }

}