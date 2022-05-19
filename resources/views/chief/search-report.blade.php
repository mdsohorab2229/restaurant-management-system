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
                <h3 class="box-title">Kitchen Report</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered" width="100%" id="kitchenReport">
                    <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>Order No</th>
                        <th>Kitchen</th>
                        <th>Waiter</th>
                        <th>Grand Total</th>
                        <th>DateTime</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @if($orders)
                        @foreach($orders as $key => $order)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $order->order_no }}</td>
                                <td>{{ $order->chief->name }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->amount }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <button class="btn btn-xs btn-primary view_data" title="view order" data-toggle="modal" data-target="#view_modal" id="{{ $order->id }}" data-order-no="{{ $order->order_no }}"><i class="fa fa-eye"></i> </button>            
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
    @include('chief.order-view-report')
@endsection
{{--// content section --}}

@push('footer-scripts')
    {{-- Datepicker Plugin --}}
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>
    {{-- laravel datatable --}}
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" />
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

                     $('#kitchenReport').DataTable({
                        language: {
                            searchPlaceholder: "Search Proudct"
                        },
                        dom: 'lBfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                     });

                    //datapicker
                    $('.date-picker').datepicker({
                        format: "yyyy-mm-dd",
                        autoclose: true
                    });
                    
                });

                
            }(jQuery));
    </script>
@endpush