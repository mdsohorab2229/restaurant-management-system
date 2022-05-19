@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Table list</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">                
                <table class="table table-bordered" id="tableData">
                        <thead>
                            <tr class="bg-success">
                                <th>#</th>
                                <th>Name</th>
                                <th>Nickname</th>
                                <th>Capacity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                @include('tables.create')
                @include('tables.edit')
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
                    var table_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("table/edit") }}',
                        method: "POST",
                        data: {table_id:table_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.name);
                            $("#table_hidden_id").val(data.id);
                            $("#nickname").val(data.nickname);
                            $("#capacity").val(data.capacity);
                        }
                    });
                });


                //get menus category
                $(document).ready(function() {
                    $('#tableData').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajax.getTableData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            { "data": "nickname" },
                            { "data": "capacity" },
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush