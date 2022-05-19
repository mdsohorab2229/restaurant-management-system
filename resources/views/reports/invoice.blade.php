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
                            {!! Form::open(['route' => 'report.invoice', 'method'=> 'get']) !!}
                                {{ csrf_field() }}
                                <div class="col-md-2">
                                    <input type="text" name="from_date" class="form-control date-picker" placeholder="From Date" autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="to_date" class="form-control date-picker" placeholder="To Date" autocomplete="off">
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
                <table id="explodefile" class="table">
                    <thead>
                        <tr class="bg-gray">
                            <th>#</th>
                            <th>Order No</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Profit</th>
                            <th>Due</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @if($invoices)
                    <tbody>
                        @foreach ($invoices as $key => $invoice)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $invoice->order->order_no }}</td>
                                <td>{{ $invoice->order->amount }}</td>
                                <td>{{ $invoice->deposit }}</td>
                                <td>{{ $invoice->profit  }}</td>
                                <td>{{ $invoice->due  }}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="{{ $invoice->id }}" data-order-no="{{ $invoice->order->order_no }}"><i class="fa fa-eye"></i> </button>
                                    <a href="{{ route('billing.print_view', $invoice->id) }}" target="_blank" class="btn btn-danger btn-xs"><i class="fa fa-print"></i> Invoice</a>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <th></th>
                            <th></th>
                            <th>{{ $invoice->order->sum('amount') }} /=</th>
                            <th>{{ $invoices->sum('deposit') }} /=</th>
                            <th>{{ $invoices->sum('profit') }} /=</th>
                            <th>{{ $invoices->sum('due') }} /=</th>
                        </tr>


                    </tbody>
                    @endif
                </table>
            </div>
            <div class="box-footer">
                
            </div>
        </div>
        @include('billing.view_order')
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
                    }); 

                    // $('#invoices').DataTable({
                    //     "processing": true,
                    //     "serverSide": true,
                    //     "ajax": "{{ route('report.get-invoice') }}",
                    //     "columns":[
                    //         { "data": "serial" },
                    //         { "data": "order.order_no" },
                    //         { "data": "order.amount" },
                    //         { "data": "deposit" },
                    //         { "data": "profit" },
                    //         { "data": "due" },
                    //         { "data": "action" }
                    //     ],
                    //     language: {
                    //         searchPlaceholder: "Search Invoice"
                    //     }
                    // });

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
                    //report download with csv
                    $(document).ready(function() {
                        $('#explodefile').DataTable( {
                            dom: 'lBfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
                        } );
                    } );

                });
                
            }(jQuery));
    </script>
@endpush
