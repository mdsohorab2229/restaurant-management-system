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
                            {!! Form::open(['route' => 'report.search-kitchenstore', 'method' => 'get']) !!}
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
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Kitchen Stock</h3>
                {{--<a href="javascript:void(0)" class="btn btn-sm btn-warning pull-right" data-toggle="modal" data-target="#send_kitchen_to_wasted">Send to Wasted</a>--}}
                {{--<a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#back_stock">Back to Store</a>--}}
            </div>
            <div class="box-body">
                <table class="table table-boredered table-hover" id="products">
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

                </table>
            </div>
            <div class="box-footer"></div>
        </div>
        @include('products.stock.create')
        @include('products.wasted.kitchen-to')
    </div>


@endsection


{{-- push footer --}}
@push('footer-scripts')
    {{-- Datepicker Plugin --}}
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>

    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/
            jQuery(document).ready(function ($) {
                //datapicker
                $('.date-picker').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true,
                });
                //get products
                $(document).ready(function() {
                    $('#products').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajax.get-kitchen-product') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "product.name" },
                            { "data": "product.discription" },
                            { "data": "product.category.name" },
                            { "data": "product.brand.name" },
                            { "data": "product.supplier.name" },
                            {
                                data: "product.cost",
                                name: "product.cost",
                                render: function( data, type, full, meta ) {
                                    if(data) {
                                        return data;
                                    }
                                    return '';
                                }

                            },
                            { "data": "quantity" },
                            { "data": "price" },
                            { "data": "product.stock.unit.name" }
                        ],
                        language: {
                            searchPlaceholder: "Search Proudct"
                        }
                    });
                });
            });

        }(jQuery));

    </script>
@endpush