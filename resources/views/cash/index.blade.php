@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Cash List</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">                
                <table class="table table-bordered" id="tableData">
                        <thead>
                            <tr class="bg-success">
                                <th>#</th>
                                <th>Name</th>
                                <th>Nickname</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                @include('cash.create')
                @include('cash.edit')
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
                    var cash_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("cashes/edit") }}',
                        method: "POST",
                        data: {cash_id:cash_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.name);
                            $("#cash_hidden_id").val(data.id);
                            $("#nickname").val(data.nick_name);
                            $("#discription").val(data.discription);
                        }
                    });
                });


                //get kitchen data
                $(document).ready(function() {
                    $('#tableData').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getCashData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            { "data": "nick_name" },
                            { "data": "discription" },
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush