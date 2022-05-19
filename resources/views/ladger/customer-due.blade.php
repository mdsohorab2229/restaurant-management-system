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
                        <h3 class="box-title">Customer Ladger</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-red">
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Customer Total Due</th>
                                    <th>Customer paid</th>
                                    <th>Current Due</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($billings) 
                                    @foreach($billings as $key => $billing)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td><a href="{{ route('customer-due', $billing->customer_id) }}">{{ $billing->customer->name }}</a></td>
                                            <td>{{ $setting->currency_prefix }} {{ $billing->total_due }} {{ $setting->currency_suffix }}</td>
                                            <td>
                                                {{ $billing->customer->customer_due->first() ? $billing->customer->customer_due->first()->total_paid : 0 }}
                                            </td>
                                            <td> {{ $billing->customer->customer_due->first() ? $billing->total_due - $billing->customer->customer_due->first()->total_paid : $billing->total_due - 0 }} </td>
                                            <td>
                                                <button class="btn btn-xs btn-primary edit_data"   data-toggle="modal" data-target="#due_take" id="{{ $billing->customer_id }}">Take Due</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-offset-6 col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Total Dues</th>
                                        <th>Total Paid</th>
                                        <th>Due</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $total_due }}</td>
                                        <td>{{ $total_paid }}</td>
                                        <td>{{ $total_due - $total_paid }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{ $billings->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('ladger.take-due')
    
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
                    var customer_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("ladger/customer-due") }}',
                        method: "POST",
                        data: {customer_id:customer_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#customer_name").html(data.name);
                            $('#current_due').val(data.total_due);
                            $('#customer_hidden_id').val(customer_id);
                        }
                    });
                });

                $(document).on('keyup change', '#paid_amount', function() {
                    var due = $('#current_due').val();
                    var paid_amount = $(this).val();
                    var current_due = parseFloat(due) - parseFloat(paid_amount);
                    $('#new_due').val(current_due);
                });
                
            });
            
        }(jQuery));

    </script>
@endpush