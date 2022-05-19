@extends('layouts.hotel-master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Category</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="roomcategory_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                </table>
                @include('hotel.roomcategory.create')
                @include('hotel.roomcategory.edit')
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
                //for edit view data
                $(document).on('click', '.edit_data',function() {
                    var roomcategory_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("roomcategory/edit") }}',
                        method: "POST",
                        data: {roomcategory_id:roomcategory_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#nam").val(data.name);
                            $("#ratee").val(data.rate);
                            $("#hidden_roomcategory_id").val(data.id);
                        }
                    });
                });

                //get roomcategory data
                $(document).ready(function() {
                    $('#roomcategory_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getroomcategoryData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            { "data": "rate" },
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush