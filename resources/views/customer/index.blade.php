@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Customers</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="customer_table" width="100%">
                    <thead>
                        <tr class="bg-success">
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                </table>
                @include('customer.create')
                @include('customer.edit')
            </div>
            <div class="box-footer"></div>
        </div>
    </div>

    
@endsection
{{--// content section --}}

{{-- push footer --}}
@push('footer-scripts')
{{-- laravel datatable --}}
    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/ 
            jQuery(document).ready(function ($) {
                
                $(document).on('click', '.edit_data',function() {
                    var customer_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("customer/edit") }}',
                        method: "POST",
                        data: {customer_id:customer_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.name);
                            $("#phone").val(data.phone);
                            $("#email").val(data.email);
                            $("#address").val(data.address);
                            $("#status").val(data.status);
                            $("#customer_hidden_id").val(data.id);
                        }
                    });
                });

                //get customer data
                $(document).ready(function() {
                    $('#customer_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getCustomerData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            { "data": "phone" },
                            { "data": "email" },
                            { "data": "address" },
                            { "data": "action" }
                        ]
                    });
                });
            });
            
        }(jQuery));

    </script>
@endpush