@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Expenses</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="customer_table" width="100%">
                    <thead>
                        <tr class="bg-success">
                            <th>#</th>
                            <th>Tile</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Purchase Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                </table>
                @include('purchase.create')
                @include('purchase.edit')
            </div>
            <div class="box-footer">
                <div class="expense_amount text-center">
                    <h3>Total Purchase Amount: <span>{{ $total_purchase }}</span></h3>
                </div>
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
                    autoclose: true
                }); 
                
                //get customer data
                $(document).ready(function() {
                    $('#customer_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getPurchaseData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "title" },
                            { "data": "purchase_category" },
                            { "data": "description" },
                            { "data": "amount" },
                            { "data": "purchase_date" },
                            { "data": "action" }
                        ]
                    });
                });
            });
            
        }(jQuery));

    </script>
@endpush