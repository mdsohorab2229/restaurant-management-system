@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Cars</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="car_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Company/Bus Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                </table>
                @include('buffetforcars.create')
                @include('buffetforcars.edit')
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
                    var car_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("buffetcars/edit") }}',
                        method: "POST",
                        data: {car_id:car_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.name);
                            $("#address").val(data.address);
                            $("#phone1").val(data.phone1);
                            $("#phone2").val(data.phone2);
                            $("#phone3").val(data.phone3);
                            $("#amount").val(data.amount);
                            $("#car_hidden_id").val(data.id);
                        }
                    });
                });

                //get car/company data
                $(document).ready(function() {
                    $('#car_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getBuffetcarsData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            { "data": "address" },
                            { "data": "phone1" },
                            { "data": "amount" },
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush