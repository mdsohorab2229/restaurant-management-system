@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Raw Material List</h3>
                <a href="javascript:void(0)" class="btn btn-sm btn-warning pull-right" data-toggle="modal" data-target="#send_wasted">Send to Wasted</a> 
                <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#send_kitchen">Send to Kitchen</a> 
                <a href="{{ url('products/create') }}" class="btn btn-sm btn-danger pull-right">Add Product</a>
                <a href="{{ url('products/wasted') }}" class="btn btn-sm btn-warning">Wasted Product</a>
                <a href="{{ url('products/kitchen') }}" class="btn btn-sm btn-info">Kitchen Stock</a>
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
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                </table>
            </div>
            <div class="box-footer">
                <h3>Product Total Price: <span>{{ $total_price }} {{ $setting->currency_suffix }}</span></h3>
            </div>
        </div>

        @include('products.kitchen.create')
        @include('products.wasted.create')
        
    </div>


@endsection
{{--// content section --}}

{{-- push footer --}}
@push('footer-scripts')
    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/
            jQuery(document).ready(function ($) {

                //get products
                $(document).ready(function() {
                    $('#products').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajax.get-product') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            { "data": "discription" },
                            { "data": "category.name" },
                            { "data": "brand.name" },
                            { "data": "supplier.name" },
                            { "data": "cost" },
                            { "data": "stock.quantity" },
                            { "data": "price" },
                            { "data": "stock.unit.name" },
                            {
                                data: 'status',
                                name: 'status',
                                render: function ( data, type, full, meta ) {
                                    return data ? "<label class='label label-success'> Active </label>" : "<label class='label label-warning'> Inactive </label>" ;
                                }
                            },
                            { "data": "action" }
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