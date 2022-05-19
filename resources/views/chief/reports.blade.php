@extends('layouts.ordering')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        {{-- filltering --}}
        <div class="box box-warning filtering">
            <div class="box-header with-border">
                <h3 class="box-title">Filtering Report</h3>
            </div>
            <div class="box-body">
                <div class="table">
                    <div class="table-cell">
                        <div class="row">                            
                            {!! Form::open(['route' => 'chief.report', 'method' => 'get']) !!}
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
            <div class="box-header with-border">
                <h3 class="box-title">Today's Report</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="kitchen_report" width="100%">
                    <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>Order No</th>
                        <th>Kitchen</th>
                        <th>Waiter</th>
                        <th>Table</th>
                        <th>Grand Total</th>
                        <th>DateTime</th>
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
    @include('chief.order-view-report')
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
                            url: '{{ url("order/menu/view") }}',
                            method: "POST",
                            data: {order_id:order_id, _token : _token},
                            success:function(data){
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
                         $('#kitchen_report').DataTable({
                             "processing": true,
                             "serverSide": true,
                             "ajax": "{{ route('report.get-kitchen-report') }}",
                             "columns":[
                                 { "data": "serial" },
                                 { "data": "order_no" },
                                 { "data": "chief.name" },
                                 { "data": "user.name" },
                                 { "data": "table.name" },
                                 { "data": "amount" },
                                 { "data": "created_at" },
                                 { "data": "action" }
                            ],
                            language: {
                                searchPlaceholder: "Search Proudct"
                            },
                         });
                     });
                    
                });

                
            }(jQuery));
    </script>
@endpush