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
            <div class="col-md-3 col-lg-3 col-xs-3">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <p>Today's Sell</p>
                        <h3>{{ count($today_sell) }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-xs-3">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <p>Today's Profit</p>
                        <h3>{{ $today_profit }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-xs-3">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <p>Total Sell</p>
                        <h3>{{ count($total_sell) }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-xs-3">
                <div class="small-box bg-green">
                    <div class="inner">
                        <p>Total Profit</p>
                        <h3>{{ $total_profit }}</h3>
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
                    <h3>Today's Billings</h3>
                </div>
            </div>
        </div>
        <div class="box box-danger">
            <div class="box-body">
                <table class="table table-bordered" id="order_process" width="100%">
                    <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Order No</th>
                        <th>Waiter Name</th>
                        <th>Total Bill</th>
                        <th>Cashier</th>
                        <th>DateTime</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        @include('billing.view_order')


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
                //get billings data
                $(document).ready(function() {
                    $('#order_process').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getdata_billingpage') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "customer.name"},
                            { "data": "order.order_no" },
                            { "data": "order.user.name" },
                            { "data": "order.amount" },
                            { "data": "created_by" },
                            { "data": "created_at" },
                            { "data": "action" }
                        ]
                    });
                });

            });
          
        }(jQuery));
    </script>
@endpush