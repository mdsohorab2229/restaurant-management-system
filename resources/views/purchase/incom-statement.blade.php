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
                            {!! Form::open(['route' => 'purchase.search-incomestatement', 'method' => 'get']) !!}
                            {{ csrf_field() }}
                            <div class="col-md-2">
                                <input type="text" name="from_date" class="form-control date-picker" placeholder="From Date" autocomplete="off">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="to_date" class="form-control date-picker" placeholder="To Date"  autocomplete="off">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
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
                            //total wasted
                            $wasted = $totalwasted->sum(function ($wasted) {
                                return $wasted->quantity*$cost = $wasted->product->cost;

                            });
                            //total kitched stock
                            $totalkitchenstoc = $totalkitchenstock->sum(function($totalkitchenstoc){
                                return $totalkitchenstoc->quantity*$cost = $totalkitchenstoc->product->cost;

                            });
                            $totalwasted_kitchenstock = $wasted + $totalkitchenstoc;
                            $totalproduct_wasted_kitchen = $total + $wasted + $totalkitchenstoc;

                        @endphp
                        <table class="table table-border table-hover" id="explodefile">
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
                                <th colspan="2" >{{ number_format($purchase=$total+$totalwasted_kitchenstock,2) }} /=</th>

                            </tr>
                            <tr>
                                <th class="danger">Cost of goods available for sale</th>
                                <th colspan="2" class="danger">{{ number_format($cosofgoodssale=$purchase+$totallastmonth, 2) }} /=</th>


                            </tr>

                            <tr style="border:1px solid red;">
                                <th>Ending Inventory</th>
                                <th colspan="2" >{{ number_format($endinv=$totalproduct_wasted_kitchen-$totalwasted_kitchenstock,2) }} /=</th>


                            </tr>

                            {{--<tr>--}}
                                {{--<th class="success">Cost of Goods Sold</th>--}}
                                {{--<th colspan="2" class="success">{{ number_format($cost_of_goods_sold=$cosofgoodssale-$endinv,2) }} /=</th>--}}
                            {{--</tr>--}}
                            @php

                                number_format($cost_of_goods_sold=$cosofgoodssale-$endinv,2);

                            @endphp

                            </tbody>
                        </table>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Income Statement</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Purchase History</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="" width="100%">
                    <thead>
                        <tr>
                            <th colspan="2">Revenues</th>
                        </tr>
                    </thead>
                      <tbody>
                        <tr style="border-bottom:2px solid darkred;">
                            <th>Sales Revenues</th>
                            <th>{{ number_format($sells,2) }} /=</th>
                            <th></th>
                        </tr>

                        <tr class="danger">
                            <th>Total Revenues</th>
                            <th></th>
                            <th>{{ number_format($sells,2) }} /=</th>
                        </tr>

                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>

                        <tr>
                            <th colspan="3">Expenses</th>
                        </tr>
                        <tr>
                            <th>Cost of Goods Sold</th>
                            <th></th>
                            <th>{{ number_format($gcs=$cost_of_goods_sold,2) }} /=</th>
                        </tr>
                        @if($expenses)
                            @foreach($expenses as $expense)
                            <tr>
                                <th>{{ $expense->expenseCategory->name }}</th>
                                <th>{{ number_format($allexp=$expense->sum,2) }}</th>
                            </tr>
                            @endforeach
                        @endif
                        <tr>
                            <th></th>
                            <th></th>
                            <th>{{ number_format($monthlyexpansesumation->sum('amount'),2) }}</th>
                        </tr>

                        <tr class="danger" style="border-top:2px solid lightgray;">
                            <th>Total Expense</th>
                            <th></th>
                            <th>{{ number_format($total=$monthlyexpansesumation->sum('amount')+$gcs,2) }}</th>
                        </tr>

                        <tr>
                            <th>Net Income</th>
                            <th></th>
                            <th>{{ number_format($sells-$total,2) }}</th>
                        </tr>
                      </tbody>
                    
                </table>
                {{--@include('purchase.create')--}}
                {{--@include('purchase.edit')--}}
            </div>

            <div class="box-footer">

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

            });
            
        }(jQuery));

    </script>
@endpush