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
                            {!! Form::open(['route' => 'report.search-wasted-stock', 'method' => 'get']) !!}
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
        {{-- reports data --}}
        <div class="box box-defaul">
            {{-- <div class="box-header with-border">
                <h3 class="box-title">Stock Report</h3>
            </div> --}}
            <div class="box-body">
                <table class="table" id="stocks">
                    <thead>
                    <tr class="bg-gray">
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
                    @if($products)

                        @foreach($products as $key => $product)
                            <tr>
                                <td> {{ $key+1 }} </td>
                                <td> {{ $product->product->name }} </td>
                                <td> {{ $product->product->discription }} </td>
                                <td> {{ $product->product->category->name }} </td>
                                <td> {{ $product->product->brand->name }} </td>
                                <td> {{ $product->product->supplier->name }} </td>
                                <td> {{ $cost=$product->product->cost }} </td>
                                <td> {{ $quantity=$product->quantity }} </td>
                                <td> {{ $total = $cost*$quantity }} </td>
                                <td> {{ $product->product->stock->unit->name }} </td>

                            </tr>
                        @endforeach
                        <tfoot>
                        <tr>
                            <th colspan="8"></th>
                            <th>{{ $totalprice = $products->sum(function ($totalprice) {
                                        return $totalprice->quantity * $totalprice->product->cost;
                                 }) }} /=</th>
                            <th></th>
                        </tr>
                        </tfoot>

                    @endif
                    
                </table>
            </div>
            <div class="box-footer"></div>
        </div>

    </div>

@endsection
{{--// content section --}}

@push('footer-scripts')
    {{-- Datepicker Plugin --}}
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>
    <script>
        (function ($) {
            "use strict";

                 jQuery(document).ready(function ($) {
                    //datapicker
                    $('.date-picker').datepicker({
                        format: "yyyy-mm-dd",
                        autoclose: true,
                        todayHighlight: true
                    }); 

                    $('#stocks').DataTable({

                        language: {
                            searchPlaceholder: "Search Proudct"
                        },
                        dom: 'lBfrtip',
                        buttons: [
                            { extend: 'copyHtml5', footer: true },
                            { extend: 'excelHtml5', footer: true },
                            { extend: 'csvHtml5', footer: true },
                            { extend: 'pdfHtml5', footer: true },
                            { extend: 'print', footer: true },
                        ]
                    });

                    

                });
                
            }(jQuery));
    </script>
@endpush
