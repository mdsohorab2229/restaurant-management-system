@extends('layouts.hotel-master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')

    <div class="jrr-class">
            <div class="box box-warning filtering">
                <div class="box-header with-border">
                    <h3 class="box-title">Filter Report</h3>
                </div>
                <div class="box-body">
                    <div class="table">
                        <div class="table-cell">
                            <div class="row">
                                {!! Form::open(['route' => 'report.search-payment', 'method' => 'get']) !!}
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
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Daily Payment Reports</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="guestPaymentData" style="width:100%">
                    <thead>
                        <tr class="bg-blue">
                            <th>SL</th>
                            <th>Booking No</th>
                            <th>Guest</th>
                            <th>Payment Date</th>
                            <th>Subtotal</th>
                            <th>Vat</th>
                            <th>Discount</th>
                            <th>Paid Amount </th>
                            <th>Due</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="box-footer">
               
            </div>
        </div>
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
                
                //datepicker
                $('.date-picker').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true
                });
                

                $('#guestPaymentData').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('ajaxdata.getGuestPaymentData') }}",
                    "columns":[
                        { "data": "serial" },
                        { "data": "roombooking.booking_no" },
                        { "data": "guest.guest_phone" },
                        {"data": "payment_date"},
                        {"data": "sub_total"},
                        {"data": "vat"},
                        {
                                data: 'discount',
                                name: 'discount',
                                render: function ( data, type, full, meta ) {
                                    return data== null ? 0 : data;
                                }
                            },
                        {"data": "paid_amount"},
                        {"data": "due"},
                        { "data": "action" }
                    ],
                    dom: 'lBfrtip',
                    buttons: [
                        // 'copy,', 'csv', 'excel', 'pdf', 'print'
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