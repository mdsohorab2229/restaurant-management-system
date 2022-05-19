@extends('layouts.hotel-master')

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
        {{-- reports data --}}
        <div class="box box-defaul">
            {{-- <div class="box-header with-border">
                <h3 class="box-title">Stock Report</h3>
            </div> --}}
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $key => $payment)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>{{ $payment->roombooking->booking_no }}</td>
                                    <td>{{ $payment->guest->guest_phone }}</td>
                                    <td>{{ $payment->payment_date }}</td>
                                    <td>{{ $payment->sub_total }}</td>
                                    <td>{{ $payment->vat }}</td>
                                    <td>{{ $payment->discount }}</td>
                                    <td>{{ $payment->paid_amount }}</td>
                                    <td>{{ $payment->due }}</td>
                                </tr>                            
                            @endforeach
                        </tbody>
                        

                    </table>
            </div>
            <div class="box-footer"></div>
        </div>

    </div>

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
                    //datapicker
                    $('.date-picker').datepicker({
                        format: "yyyy-mm-dd",
                        autoclose: true,
                        todayHighlight: true
                    });

                    $('#guestPaymentData').DataTable({

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
