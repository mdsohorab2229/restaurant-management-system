@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Cash Cashier List</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">                
                <table class="table table-bordered" id="tableData">
                        <thead>
                            <tr class="bg-success">
                                <th>#</th>
                                <th>Cash Name</th>
                                <th>Cashier Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                @include('cash.cashcashier.create')
                @include('cash.cashcashier.edit')
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
                    var cashcashier_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("cashes/editcashcashier") }}',
                        method: "POST",
                        data: {cashcashier_id:cashcashier_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#cash").val(data.cash_id);
                            $("#userr").val(data.user_id);
                            $("#cashcashier_hidden_id").val(data.id);
                        }
                    });
                });


                //get kitchen data
                $(document).ready(function() {
                    $('#tableData').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getCashCashierData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "cash.name" },
                            { "data": "user.name" },
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush