@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Card</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="discount_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Name</th>
                        <th>Card Number</th>
                        <th>Percentage(%)</th>
                        <th>Expire Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                </table>
                @include('discountcard.create')
                @include('discountcard.create_customer')
                @include('discountcard.edit')
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
                    var discountcard_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("discountcard/edit") }}',
                        method: "POST",
                        data: {discountcard_id:discountcard_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#customer").val(data.customer_id);
                            $("#number").val(data.cardnumber);
                            $("#percent").val(data.discount);
                            $(".expire").val(data.expiredate);
                            $("#discountcard").val(data.id);
                        }
                    });
                });

                //get discountcard data
                $(document).ready(function() {
                    $('#discount_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getDiscountcardData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "customer.customer_phone" },
                            { "data": "cardnumber" },
                            { "data": "discount"},
                            { "data": "expiredate"},
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush