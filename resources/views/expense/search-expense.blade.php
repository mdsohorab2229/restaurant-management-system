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

        {{-- reports data --}}
        <div class="box box-defaul">
            {{-- <div class="box-header with-border">
                <h3 class="box-title">Stock Report</h3>
            </div> --}}
            <div class="box-body">
                <table class="table table-bordered" id="explodefile" width="100%">
                    <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>Category</th>
                        <th>Discription</th>
                        <th>Amount</th>
                        <th>Expanse Date</th>

                    </tr>
                    </thead>
                    @if($expenses)
                        @foreach($expenses as $key => $expense)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $expense->expenseCategory->name }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>{{ $expense->amount }}</td>
                                <td>{{ $expense->expense_date }}</td>

                            </tr>
                        @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th>Total :- {{$expenses->sum('amount')}}</th>

                            </tr>

                    @endif
                </table>
            </div>


            <div class="box-body">
                <table class="table table-bordered" id="explodefi" width="100%">
                    <thead>
                    <tr class="bg-gray">
                        <th>#</th>
                        <th>Category</th>
                        <th>Amount</th>

                    </tr>
                    </thead>
                    @if($ts)
                        @foreach($ts as $key => $t)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $t->expenseCategory->name }}</td>
                                <td>{{ number_format($t->sum,2) }}</td>

                            </tr>
                        @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <th>Total:-{{$expenses->sum('amount')}}</th>
                            </tr>

                    @endif
                </table>
            </div>
        </div>
        <div class="box-footer">

            <div class="expense_amount text-center">
                <h3>Total Expense Amount: <span>{{$expenses->sum('amount')}}</span></h3>
            </div>

        </div>

    </div>
    @include('billing.view_order')
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
                        todayHighlight: true,

                    });

                    //report download with csv
                        $('#explodefile').DataTable( {
                            dom: 'lBfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
                        });
                     $('#explodefi').DataTable( {
                         dom: 'lBfrtip',
                         buttons: [ 
                             'copy', 'csv', 'excel', 'pdf', 'print'
                         ]
                     });


                });

                
            }(jQuery));
    </script>
@endpush