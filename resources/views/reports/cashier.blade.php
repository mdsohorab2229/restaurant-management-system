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

                            <div class="col-md-2">
                                <button class="btn btn-danger"><i class="fa fa-search"></i> Search</button>
                            </div>
                                {{--<div class="col-md-3">--}}
                                    {{--<div class="controls input-append date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">--}}
                                        {{--<input class="form-control" name="from_date" type="text" value="" readonly>--}}
                                        {{--<span class="add-on"><i class="icon-remove"></i></span>--}}
                                        {{--<span class="add-on"><i class="icon-th"></i></span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-3">--}}
                                    {{--<div class="controls input-append date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">--}}
                                        {{--<input class="form-control" name="to_date" type="text" value="" readonly>--}}
                                        {{--<span class="add-on"><i class="icon-remove"></i></span>--}}
                                        {{--<span class="add-on"><i class="icon-th"></i></span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--<!-- Date and time range -->--}}

                            <!-- /.form group -->

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
                <table class="table table-bordered" id="order_process" width="100%">
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
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-timepicker/css/bootstrap-datetimepicker.min.css') }}">
    <script src="{{ asset("bower_components/bootstrap-timepicker/js/bootstrap-datetimepicker.min.js") }}"></script>

    <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>
    <script src="{{ asset("bower_components/bootstrap-daterangepicker/moment.min.js") }}"></script>
    <script src="{{ asset("bower_components/bootstrap-daterangepicker/daterangepicker.js") }}"></script>

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
                     $(document).ready(function() {
                         $('#order_process').DataTable({
                             "processing": true,
                             "serverSide": true,
                             "ajax": "{{ route('report.get-cashierreport') }}",
                             "columns":[
                                 { "data": "serial" },
                                 { "data": "order.order_no" },
                                 { "data": "order.amount" },
                                 { "data": "created_at" },
                                 { "data": "created_by" },
                                 { "data": "action" },

                             ],
                             dom: 'lBfrtip',
                             buttons: [
                                 'copy', 'csv', 'excel', 'pdf', 'print'
                             ]
                         });
                     });



                });
            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })


            }(jQuery));
        $('.form_datetime').datetimepicker({
            //language:  'fr',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });
    </script>
@endpush