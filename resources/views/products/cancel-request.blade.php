@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Canceled Raw Materials</h3>
            </div>
            <div class="box-body">
                <table class="table table-boredered table-hover" id="products">
                    <thead>
                        <tr class="bg-gray">
                            <th>#</th>
                            <th>Name</th>
                            <th>Supplier</th>
                            <th>Quntity</th>
                            <th>Unit</th>
                            <th>Cost Per unit</th>
                            <th>Total Cost</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    
                </table>
            </div>
            <div class="box-footer">
                {{-- <h3>Product Total Price: <span>{{ $total_price }} {{ $setting->currency_suffix }}</span></h3> --}}
            </div>
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
                        "ajax": "{{ route('ajax.get-canceled-product') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "product.name" },
                            { "data": "product.supplier.name" },
                            { "data": "quantity" },
                            { "data": "product.stock.unit.name" },
                            { "data": "price" },
                            { "data": "total_price" },
                            {
                                data: 'status',
                                name: 'status',
                                render: function ( data, type, full, meta ) {
                                    return data==2 ? "<label class='label label-info'>Canceled<label>" : "";
                                }
                            }
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