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
                            {!! Form::open(['route' => 'reportsearch.list', 'method'=> 'get']) !!}
                            {{ csrf_field() }}
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::select('expense_category', makeDropdown($categories) , null, ["class" => "form-control"])!!}
                                    <small class="text-danger">{{ $errors->first('expense_category') }}</small>
                                </div>
                            </div>
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
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Expense Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                </table>
                @include('expense.create')
                @include('expense.edit')
            </div>
            <div class="box-footer">
                <div class="expense_amount text-center">
                    <h3>Total Expense Amount: <span>{{ $total_expense }}</span></h3>
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
                    autoclose: true,
                    todayHighlight: true,
                    autocomplete:"off",
                }); 
                
                $(document).on('click', '.edit_data',function() {
                    var expense_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("expense/edit") }}',
                        method: "POST",
                        data: {expense_id:expense_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#titlee").val(data.title);
                            $("#descrive").val(data.description);
                            $("#expdate").val(data.expense_date);
                            $("#amountt").val(data.amount);
                            $("#expcategory").val(data.expense_category_id);
                            $("#expense_hidden_id").val(data.id);
                        }
                    });
                });

                //get expanse data
                $(document).ready(function() {
                    $('#customer_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getExpenseData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "expense_category" },
                            { "data": "description" },
                            { "data": "amount" },
                            { "data": "expense_date" },
                            { "data": "action" }
                        ],
                        dom: 'lBfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
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