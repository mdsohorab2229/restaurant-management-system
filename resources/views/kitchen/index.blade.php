@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Kitchen List</h3>
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
                @include('kitchen.create')
                @include('kitchen.edit')
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
                    var kitchen_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("kitchens/edit") }}',
                        method: "POST",
                        data: {kitchen_id:kitchen_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.name);
                            $("#kitchen_hidden_id").val(data.id);
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
                        "ajax": "{{ route('ajaxdata.getKitchenData') }}",
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