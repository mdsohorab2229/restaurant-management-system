@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Discount</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="discountcustomer_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Card Number</th>
                        <th>Discount(%)</th>
                        <th>Expire Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                </table>
                @include('discountcard.discountlist.create')
                @include('discountcard.discountlist.edit')
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
                    var customerdiscount_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("discountcard/discountedit") }}',
                        method: "POST",
                        data: {customerdiscount_id:customerdiscount_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#customername").val(data.customer_id);
                            $("#cardnumber").val(data.discountcard_id);
                            $(".expire").val(data.expiredate);
                            $("#discountcard").val(data.id);
                        }
                    });
                });

                //get discountcard data
                $(document).ready(function() {
                    $('#discountcustomer_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getDiscountcustomerData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "customer.name" },
                            { "data": "discountcard.cardnumber"},
                            { "data": "discountcard.discount"},
                            { "data": "discountcard.expiredate"},
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush