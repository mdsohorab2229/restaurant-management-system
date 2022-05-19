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
                            {!! Form::open(['route' => 'report.cashier', 'method' => 'get']) !!}
                                {{ csrf_field() }}
                                <div class="col-md-2">
                                    <input type="text" name="from_date" class="form-control date-picker" placeholder="From Date" autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="to_date" class="form-control date-picker" placeholder="To Date"  autocomplete="off">
                                </div>
                                {{--<div class="col-md-2">--}}
                                    {{--{!! Form::select('menu_name', makeDropdown($billings) , null, ["class" => "form-control"])!!}--}}
                                {{--</div>--}}
                                {{--<div class="col-md-2">--}}
                                    {{--<select class="form-control">--}}
                                        {{--<option value="">Day Shift</option>--}}
                                        {{--<option value="">Night Shift</option>--}}
                                    {{--</select>--}}
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

        {{-- reports data --}}
        <div class="box box-defaul">
            {{-- <div class="box-header with-border">
                <h3 class="box-title">Stock Report</h3>
            </div> --}}
            <div class="box-body">
                <table class="table table-bordered" id="explodefile" width="100%">
                    <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>Order No</th>
                        <th>Total Bill</th>
                        <th>Date & Time</th>
                        <th>Cashier Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @if($billings)
                        @foreach($billings as $key => $billing)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $billing->order->order_no }}</td>
                                <td>{{ $billing->order->amount }}</td>
                                <td>{{ $billing->created_at }}</td>
                                <td>{{ $billing->created_by }}</td>
                                <td>
                                    <button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="{{ $billing->id }}" data-order-no="{{ $billing->order_no }}"><i class="fa fa-eye"></i> </button>
                                </td>
                            </tr>
                        @endforeach

                    @endif
                </table>
            </div>
            <div class="box-footer">

                {{--{{ $all_menus->links() }}--}}

            </div>
        </div>

    </div>
    @include('billing.view_order')
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
                    //datapicker
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