@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        {{-- filltering --}}
        <div class="box box-warning filtering">
            <div class="box-header with-border">
                <h3 class="box-title">Filter Report</h3>
            </div>
            <div class="box-body">
                <div class="table">
                    <div class="table-cell">
                        <div class="row">
                            {!! Form::open(['route' => 'purchase.report', 'method' => 'get']) !!}
                            {{ csrf_field() }}
                            <div class="col-md-2">
                                <input type="text" name="from_date" class="form-control date-picker" placeholder="From Date" autocomplete="off">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="to_date" class="form-control date-picker" placeholder="To Date"  autocomplete="off">
                            </div>
                            {{--<div class="col-md-2">--}}
                            {{--{!! Form::select('menu_name', makeDropdown($all_menus) , null, ["class" => "form-control"])!!}--}}
                            {{--</div>--}}
                            <div class="col-md-2">
                                <button class="btn btn-danger"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Expenses</h3>
                {{--<a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Purchase History</a>--}}
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="explodefile" width="100%">
                    <thead>
                        <tr class="bg-success">
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Supplier</th>
                            <th>Cost</th>
                            <th>Stocks</th>
                            <th>Price</th>
                            <th>Unit</th>

                        </tr>
                    </thead>
                      <tbody>
                        @foreach($products as $key => $product)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->discription}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->brand->name}}</td>
                            <td>{{$product->supplier->name}}</td>
                            <td>{{$product->cost}}</td>
                            <td>{{$product->stock->quantity}}</td>
                            <td>
                                @php
                                    $quantity = $product->stock->quantity;
                                    $cost = $product->cost;



                                @endphp
                                {{$total=$quantity*$cost}}</td>
                            <td>{{$product->stock->unit->name}}</td>

                        </tr>

                        @endforeach
                      </tbody>
                    
                </table>
                {{--@include('purchase.create')--}}
                {{--@include('purchase.edit')--}}
            </div>
            @php
                $total = $products->sum(function ($product) {
                            return $product->stock->quantity*$cost = $product->cost;
                });
                //last month total
                $lastmonthtotal = $lastmonthproducts->sum(function ($product) {
                            return $product->stock->quantity*$cost = $product->cost;
                 //total last month

                });
                 $totallastmonth = $total + $lastmonthtotal;
            @endphp
            <div class="box-footer">
                <div class="expense_amount text-center">

                    <h3>Total Purchase Amount: <span>{{$total}}</span></h3>
                </div>
            </div>
        </div>
    </div>

    <!--- for purchase History--->
    <div class="modal fade" id="add_modal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">History</h4>
                </div>
                {!! Form::open(['route' => 'purchase.store']) !!}
                {{ csrf_field() }}
                <div class="modal-body">
                    <h4 style="color:lightseagreen;" class="text-center font-weight-bold">The Tinted View</h4>
                    <h4 style="color:blue;"class="text-center font-weight-bold">Cost of Goods Sold Computation</h4>
                    <hr style="background-color: red; height: 1px; border: 2px;">
                    <table class="table table-border table-hover">
                        <thead>

                        <tr>
                            <th scope="row" colspan="4">Cost of goods solds:-</th>


                        </tr>
                        <tr style="border:1px solid red;">
                            <th scope="col">Total Sell</th>
                            <th></th>
                            <th scope="col">{{ number_format($sells,2) }} /=</th>

                        </tr>
                        <tr>
                            <th scope="col" class="info">Beginning inventory</th>
                            <th colspan="2" scope="col" class="info">
                                {{ number_format($lastmonthtotal,2) }} /=</th>

                        </tr>
                        </thead>
                        <tbody>
                            <tr style="border:1px solid red;">
                                <th>Purchases</th>
                                <th colspan="2" >{{ number_format($total,2) }} /=</th>

                            </tr>
                            <tr>
                                <th class="danger">Cost of goods available for sale</th>
                                <th colspan="2" class="danger">{{ number_format($totallastmonth, 2) }} /=</th>


                            </tr>

                            <tr style="border:1px solid red;">
                                <th>Ending Inventory</th>
                                <th colspan="2" >{{ number_format($total,2) }} /=</th>


                            </tr>

                            <tr>
                                <th class="success">Cost of Goods Sold</th>
                                <th colspan="2" class="success">{{ number_format($totallastmonth-$total,2) }} /=</th>


                            </tr>


                        </tbody>
                    </table>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
    
@endsection
{{--// content section --}}

{{-- push footer --}}
@push('footer-scripts')
{{-- laravel datatable --}}
{{-- Datepicker Plugin --}}
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
<script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>
    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/ 
            jQuery(document).ready(function ($) {

                $('.date-picker').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true
                });
                //report download with csv
                $('#explodefile').DataTable( {
                    dom: 'lBfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                } );

                
                {{--//get customer data--}}
                {{--$(document).ready(function() {--}}
                    {{--$('#customer_table').DataTable({--}}
                        {{--"processing": true,--}}
                        {{--"serverSide": true,--}}
                        {{--"ajax": "{{ route('ajaxdata.getPurchaseData') }}",--}}
                        {{--"columns":[--}}
                            {{--{ "data": "serial" },--}}
                            {{--{ "data": "title" },--}}
                            {{--{ "data": "purchase_category" },--}}
                            {{--{ "data": "description" },--}}
                            {{--{ "data": "amount" },--}}
                            {{--{ "data": "purchase_date" },--}}
                            {{--{ "data": "action" }--}}
                        {{--]--}}
                    {{--});--}}
                {{--});--}}
            });
            
        }(jQuery));

    </script>
@endpush