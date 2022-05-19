@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Wasted Products</h3>
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
                        "ajax": "{{ route('ajax.get-wasted-product') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "product.name" },
                            { "data": "product.discription" },
                            { "data": "product.category.name" },
                            { "data": "product.brand.name" },
                            { "data": "product.supplier.name" },
                            { "data": "product.cost" },
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