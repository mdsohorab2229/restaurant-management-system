@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        {{-- daily activities --}}
        <div class="section-title">

        </div>
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xs-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <p>Pending Orders</p>
                        <h3>{{ count($pending_order) }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-4">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <p>On Going</p>
                        <h3>{{ count($ongoing_order) }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-4">
                <div class="small-box bg-green">
                    <div class="inner">
                        <p>Complete Orders</p>
                        <h3>{{ count($total_order) }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h3>Today's Orders</h3>
                </div>
            </div>
        </div>
        <div class="box box-danger">
            <div class="box-body">
                <table class="table table-bordered" id="order_process" width="100%">
                    <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>Order No</th>
                        <th>Table Name</th>
                        <th>Total Bill</th>
                        <th>Order By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        @include('billing.view_order')
        @include('billing.payment')

    </div>
@endsection
{{-- push footer --}}
@push('footer-scripts')
    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/
            jQuery(document).ready(function ($) {
                $(document).on('click', '.view_data',function() {
                    var order_no = $(this).data('order-no');
                    var order_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("billing/order_view") }}',
                        method: "POST",
                        data: {order_id:order_id, _token : _token},
                        success:function(data) {
                            $('#order_no').html(order_no);
                            $('#menuTable').html(data);
                        }
                    });
                });
                //get billing data
                $(document).ready(function() {
                    $('#order_process').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getOrderDataForBilling') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "order_no"},
                            {
                                data: 'table.name',
                                name: 'table.name',
                                render: function ( data, type, full, meta ) {
                                    return data==null ? "POS" : data;
                                }
                            },
                            { "data": "amount" },
                            { "data": "user.name" },
                            {
                                data: 'status',
                                name: 'status',
                                render: function ( data, type, full, meta ) {
                                    return data==0 ? "<label class='label label-info'> Pending </label>" : data==1 ? "<label class='label label-warning'> Served </label>" : data==2 ? "<label class='label label-success'> Complete </label>" : data==3 ? "<label class='label label-danger'> Canceled </label>" : "";
                                }
                            },
                            { "data": "action" }
                        ]
                    });
                });

            });
            // for billing page display
            $(document).on('click', '.make_payment',function() {
                var order_no = $(this).data('order-no');
                var order_id = $(this).attr('id');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url("billing/make_payment") }}',
                    method: "POST",
                    data: {order_id:order_id, _token : _token},
                    dataType: 'json',
                    success:function(data) {
                        $('#display_order_no').html(order_no);
                        $('#display_order_item').html(data.output);
                        $('#defaultDiscount').val(parseFloat(data.default_discount));
                        $('#due').val(parseFloat(data.due));
                    }
                });
            });

        }(jQuery));
    </script>
@endpush