@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Software Configuration settings</h3>
            </div>
            {!!Form::open(['route'=>'settings.update', 'method' => 'post', 'class' => 'settings_table']) !!}
            {{ csrf_field() }}
            @if($setting)
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="restaurant_name">Restaurant name</label>
                            <input type="text" name="restaurant_name" id="restaurant_name" class="form-control" placeholder="Enter Restaurant name" value="{{ $setting->restaurant_name }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">Default Phone</label>
                            <input type="tel" maxlength="14" name="phone" id="phone" class="form-control" placeholder="Phone" value="{{ $setting->phone }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Default Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ $setting->email }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="address">Restaurant Address</label>
                            <input type="text"  name="address" id="address" class="form-control" placeholder="Address" value="{{ $setting->address }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_category">Default Category</label>
                            {!! Form::select('default_category', makeDropDown($categories), $setting->category_id, ["class" => "form-control"])!!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_brand">Default Brand</label>
                            {!! Form::select('default_brand', makeDropDown($brands), $setting->brand_id, ["class" => "form-control"])!!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_customer">Default Customer</label>
                            {!! Form::select('default_customer', makeDropDown($customers), $setting->customer_id, ["class" => "form-control"])!!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_brand">Default Supplier</label>
                            {!! Form::select('default_supplier', makeDropDown($suppliers), $setting->supplier_id, ["class" => "form-control"])!!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="currency_code">Currency Code</label>
                            <input type="text" name="currency_code" id="currency_code" class="form-control" placeholder="Enter Currency Code" value="{{ $setting->currency_code }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="currency_prefix">Currency Prefix</label>
                            <input type="text" name="currency_prefix" id="currency_prefix" class="form-control" placeholder="Enter Currency Prefix" value="{{ $setting->currency_prefix }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="currency_suffix">Currency Suffix</label>
                            <input type="text" name="currency_suffix" id="currency_suffix" class="form-control" placeholder="Enter Currency Suffix" value="{{ $setting->currency_suffix }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_discount">Discount</label>
                            <div class="input-group">
                                <input type="number" name="discount" min="0" step="0.01" id="defaultDiscount" placeholder="i.e. 10%" class="form-control" value="{{ $setting->discount }}"> 
                                <span title="check for fixed" class="input-group-addon" style="padding: 0px;">
                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                        <input type="radio" name="discount_type" value="0" @if($setting->discount_type==0) checked @endif>&nbsp; Fixed
                                    </label>
                                </span>
                                <span title="check for percentage" class="input-group-addon" style="padding: 0px;">
                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                        <input type="radio" name="discount_type" value="1" @if($setting->discount_type==1) checked @endif>&nbsp; %
                                    </label>
                                </span>
                                <span title="discount on/off" class="input-group-addon" style="padding: 0px;">
                                    <input type="checkbox" name="discount_on_off" {{ $setting->discount_switch ? "checked" : ""}} data-toggle="toggle">
                                </span>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="default_tax">Vat</label>
                            <div class="input-group">
                                <input type="number" name="tax" min="0" step="0.01" id="defaultDiscount" placeholder="i.e. 10%" class="form-control" value="{{ $setting->tax }}"> 
                                {{-- <span title="if tax inclusive" class="input-group-addon" style="padding: 0px;">
                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                        <input type="radio" name="tax_type" value="0" @if($setting->tax_type==0) checked @endif>&nbsp; Inclusive
                                    </label>
                                </span> --}}
                                <span title="if tax Exclusive" class="input-group-addon" style="padding: 0px;">
                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                        <input type="radio" name="tax_type" value="1"  @if($setting->tax_type==1) checked @endif>&nbsp; Exclusive
                                    </label>
                                </span>
                                <span title="discount on/off" class="input-group-addon" style="padding: 0px;">
                                    <input type="checkbox" name="tax_on_off" {{ $setting->tax_switch ? "checked" : ""}} data-toggle="toggle">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update</button>
            </div>
            @else
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="restaurant_name">Restaurant name</label>
                            <input type="text" name="restaurant_name" id="restaurant_name" class="form-control" placeholder="Enter Restaurant name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">Default Phone</label>
                            <input type="tel" maxlength="14" name="phone" id="phone" class="form-control" placeholder="Phone">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Default Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="address">Restaurant Address</label>
                            <input type="text"  name="address" id="address" class="form-control" placeholder="Address">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_category">Default Category</label>
                            {!! Form::select('default_category', makeDropDown($categories), null, ["class" => "form-control"])!!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_brand">Default Brand</label>
                            {!! Form::select('default_brand', makeDropDown($brands), null, ["class" => "form-control"])!!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_customer">Default Customer</label>
                            {!! Form::select('default_customer', makeDropDown($customers), null, ["class" => "form-control"])!!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_brand">Default Supplier</label>
                            {!! Form::select('default_supplier', makeDropDown($suppliers), null, ["class" => "form-control"])!!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="currency_code">Currency Code</label>
                            <input type="text" name="currency_code" id="currency_code" class="form-control" placeholder="Enter Currency Code">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="currency_prefix">Currency Prefix</label>
                            <input type="text" name="currency_prefix" id="currency_prefix" class="form-control" placeholder="Enter Currency Prefix">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="currency_suffix">Currency Suffix</label>
                            <input type="text" name="currency_suffix" id="currency_suffix" class="form-control" placeholder="Enter Currency Suffix">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="default_discount">Default Discount</label>
                            <div class="input-group">
                                <input type="number" name="default_discount" min="0" step="0.01" id="defaultDiscount" placeholder="i.e. 10%" class="form-control"> 
                                <span title="check for fixed" class="input-group-addon" style="padding: 0px;">
                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                        <input type="radio" name="default_discount_type" value="0" false-value="0">&nbsp; Fixed
                                    </label>
                                </span>
                                <span title="check for percentage" class="input-group-addon" style="padding: 0px;">
                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                        <input type="radio" name="default_discount_type" value="1">&nbsp; %
                                    </label>
                                </span>
                                <span title="discount on/off" class="input-group-addon" style="padding: 0px;">
                                    <input type="checkbox" name="discount_on_off"  data-toggle="toggle">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="default_tax">Default Tax</label>
                            <div class="input-group">
                                <input type="number" name="default_tax" min="0" step="0.01" id="defaultDiscount" placeholder="i.e. 10%" class="form-control"> 
                                <span title="if tax inclusive" class="input-group-addon" style="padding: 0px;">
                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                        <input type="radio" name="default_tax_type" value="0" false-value="0">&nbsp; Inclusive
                                    </label>
                                </span>
                                <span title="if tax Exclusive" class="input-group-addon" style="padding: 0px;">
                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                        <input type="radio" name="default_tax_type" value="1" false-value="0">&nbsp; Exclusive
                                    </label>
                                </span>
                                <span title="discount on/off" class="input-group-addon" style="padding: 0px;">
                                    <input type="checkbox" name="tax_on_off" data-toggle="toggle">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Save</button>
            </div>
            @endif

            {!! Form::close() !!}

        </div>
    </div>

    
@endsection
{{--// content section --}}

{{-- push footer --}}
@push('footer-scripts')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/ 
            jQuery(document).ready(function ($) {

            });
            
        }(jQuery));
    </script>
@endpush