@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        {{-- filltering --}}
        {{--<div class="box box-warning filtering">--}}
            {{--<div class="box-header with-border">--}}
                {{--<h3 class="box-title">Filter Report</h3>--}}
            {{--</div>--}}
            {{--<div class="box-body">--}}
                {{--<div class="table">--}}
                    {{--<div class="table-cell">--}}
                        {{--<div class="row">--}}
                            {{--{!! Form::open(['route' => 'bankmoney.filter', 'method'=> 'get']) !!}--}}
                            {{--{{ csrf_field() }}--}}
                            {{--<div class="col-md-2">--}}
                                {{--<div class="form-group">--}}

                                    {{--{!! Form::select('bank_list', makeDropdown($banklists) , null, ["class" => "form-control"])!!}--}}
                                    {{--<small class="text-danger">{{ $errors->first('bank_list') }}</small>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-2">--}}
                                {{--<div class="form-group">--}}

                                    {{--{!! Form::select('type', getBankType() , null, ["class" => "form-control"])!!}--}}
                                    {{--<small class="text-danger">{{ $errors->first('type') }}</small>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-2">--}}
                                {{--<input type="text" name="from_date" class="form-control date-picker" placeholder="From Date" autocomplete="off">--}}
                            {{--</div>--}}
                            {{--<div class="col-md-2">--}}
                                {{--<input type="text" name="to_date" class="form-control date-picker" placeholder="To Date" autocomplete="off">--}}
                            {{--</div>--}}
                            {{--<div class="col-md-2">--}}
                                {{--<button class="btn btn-danger"><i class="fa fa-search"></i> Search</button>--}}
                            {{--</div>--}}
                            {{--{!! Form::close() !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Investment Capital List</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="bank_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Purpose</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>

                    <tr>
                        <th></th>
                        <th>Total</th>
                        <th>{{ number_format($totalinvestments, 2)  }} {{ $setting->currency_suffix  }}</th>
                        <th></th>
                        <th></th>

                        <th></th>
                        <th></th>

                        <th></th>
                    </tr>
                    </tfoot>

                </table>

                @include('investments.create')
                @include('investments.edit')
            </div>
            <div class="box-footer"></div>
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
                
                $(document).on('click', '.edit_data',function() {
                    var investment_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("investments/edit") }}',
                        method: "POST",
                        data: {investment_id:investment_id, _token : _token},
                        dataType:"json",
                        success:function(data){

                            $("#name").val(data.investor_name);
                            $("#amount").val(data.amount);
                            $("#purpose").val(data.purpose);
                            $("#_date").val(data.submit_date);
                            $("#description").val(data.description);
                            $("#status").val(data.status);
                            $("#investment_hidden_id").val(data.id);
                        }
                    });
                });

                //get bankcategory data
                $(document).ready(function() {
                    $('#bank_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.InvestmentData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "investor_name" },
                            { "data": "amount" },
                            { "data": "purpose" },
                            { "data": "submit_date" },
                            { "data": "description" },
                            {
                                data: 'status',
                                name: 'status',
                                render: function ( data, type, full, meta ) {
                                    return data==1 ? "<label class='label label-success'> Active </label>" : data==0 ? "<label class='label label-danger'> InActive </label>" : "" ;
                                }
                            },
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
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush