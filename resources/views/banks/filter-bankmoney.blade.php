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
                            {!! Form::open(['route' => 'bankmoney.filter', 'method'=> 'get']) !!}
                            {{ csrf_field() }}
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::select('bank_list', makeDropDown($banks) , null, ["class" => "form-control"])!!}
                                    <small class="text-danger">{{ $errors->first('bank_list') }}</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::select('type', getBankType() , null, ["class" => "form-control"])!!}
                                    <small class="text-danger">{{ $errors->first('type') }}</small>
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
                <h3 class="box-title">Bank Money</h3>

            </div>
            <div class="box-body">

                <h4 class="box-title text-danger">Report of {{ $bankname  }}</h4>
                <table class="table table-bordered" id="calculation_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Deposit</th>
                        <th>Withdraw</th>
                        <th>Difference</th>

                    </tr>
                    </thead>
                    @foreach($bankmoneies as $key => $bankmoney)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ user_formatted_date($bankmoney->submit_date) }}</td>
                            <td> {{ $bankmoney->description }} </td>
                            <td>
                                @if($bankmoney->type == 'deposite')
                                    {{  number_format($bankmoney->Amount, 2) }}
                                @else
                                    {{ number_format(0, 2)  }}
                                @endif
                            </td>
                            <td>
                                @if($bankmoney->type == 'withdraw')
                                    {{  number_format($bankmoney->Amount, 2) }}
                                    @else
                                    {{ number_format(0, 2)  }}
                                @endif
                            </td>
                            <td>
                                @if($bankmoney->type == 'deposite')
                                    {{  number_format(($total+=$bankmoney->Amount), 2) }}
                                    @elseif($bankmoney->type == 'withdraw')
                                    {{  number_format(($total-=$bankmoney->Amount), 2) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="color:blue;" class="text-center">
                                Current Balance :- {{ number_format($total, 2) }} /=
                            </th>


                        </tr>

                    </tfoot>
                </table>

            </div>
            <div class="box-footer"></div>
        </div>
    </div>

    
@endsection
{{--// content section --}}

{{-- push footer --}}
@push('footer-scripts')
    <!-- date-range-picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-timepicker/css/timepickerr.min.css') }}">
    <script src="{{ asset("bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js") }}"></script>


    <script>

        (function ($) {
            "use strict";

            /*at document loading time*/ 
            jQuery(document).ready(function ($) {
                
                $(document).on('click', '.edit_data',function() {
                    var bankmoney_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("banks/edit") }}',
                        method: "POST",
                        data: {bankmoney_id:bankmoney_id, _token : _token},
                        dataType:"json",
                        success:function(data){

                            $("#name").val(data.banklist_id);
                            $("#category").val(data.bankcategory_id);
                            $("#amount").val(data.Amount);
                            $("#_date").val(data.submit_date);
                            $("#description").val(data.description);
                            $("#status").val(data.status);
                            $("#bankmoney_hidden_id").val(data.id);
                        }
                    });
                });

                //get bankcategory data
                $(document).ready(function() {
                    $('#bank_table').DataTable({

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

                    $('#calculation_table').DataTable({

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

            $('.date-picker').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
            });
            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            });
            
        }(jQuery));
    </script>
@endpush