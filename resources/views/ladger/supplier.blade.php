@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        <di class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Supplier Ledger</h3>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" id="supplier_ledger_table">
                            <thead>
                                <tr class="bg-red">
                                    <th>#</th>
                                    <th>Supplier</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Due</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="box-footer">
                        <table class="table">
                            <tr>
                                <th>Total Product Bill</th>
                                <th>Total Paid </th>
                                <th>Due</th>
                            </tr>
                            <tr>                                
                                <td>{{ $setting->currency_prefix }} {{ $amount ? $amount : 0 }} {{ $setting->currency_suffix }}</td>
                                <td>{{ $setting->currency_prefix }} {{ $paid_amount ? $paid_amount : 0 }} {{ $setting->currency_suffix }}</td>
                                <td>{{ $setting->currency_prefix }} {{ $due ? $due : 0 }} {{ $setting->currency_suffix }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @include('ladger.create-supplier-ledger')
                @include('ladger.edit-supplier-ledger')
            </div>
        </div>
    </div>
    
@endsection
{{--// content section --}}

{{-- push footer --}}
@push('footer-scripts')
{{-- laravel datatable --}}
{{-- Datepicker Plugin --}}
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
<script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>

    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/ 
            jQuery(document).ready(function ($) {

                $('.date-picker').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true
                });

                

                $(document).on('click', '.edit_data',function() {
                    var sledger_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("ladger/supplier-ledger/edit") }}',
                        method: "POST",
                        data: {sledger_id:sledger_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#supplier_id").val(data.supplier_id);
                            //$("#supplier_description").val(data.description);
                            $('.description').html(data.description);
                            $("#bill_amount").val(data.amount);
                            $("#paid_amount").val(data.paid_amount);
                            $("#due").val(data.due);
                            $("#date_picker").val(data.date);
                            $("#ledger_hidden_id").val(data.id);
                        }
                    });
                });

                //get  data
                $(document).ready(function() {
                    $('#supplier_ledger_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getSupplierLedgerData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "supplier.name" },
                            { "data": "amount" },
                            { "data": "paid_amount" },
                            { "data": "due" },
                            { "data": "date" },
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        }(jQuery));

    </script>
@endpush