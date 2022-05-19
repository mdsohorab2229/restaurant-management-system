@extends('layouts.hotel-master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')

<div class="jrr-class">

    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">All Room</h3>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
        </div>
        <div class="box-body">
            <table class="table table-bordered" id="room_table" width="100%">
                <thead>
                <tr class="bg-success">
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Room</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
            @include('hotel.roombooking.create')
            @include('hotel.roombooking.edit')
        </div>
        <div class="box-footer"></div>
    </div>
</div>

@endsection
{{-- push footer --}}
@push('footer-scripts')

    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/ 
            jQuery(document).ready(function ($) {
                
                $(document).on('click', '.edit_data',function() {
                    var roombooking_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("roombooking/edit") }}',
                        method: "POST",
                        data: {roombooking_id:roombooking_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            console.log(data);
                            $("#guestname").val(data.guest_id);
                            $("#room_number").val(data.room_no);
                            $("#room_nam").val(data.name);
                            $("#room_typ").val(data.roomcategory_id);
                            $("#capacit").val(data.capacity);
                            $("#descriptio").val(data.description);
                            $("#statu").val(data.status);
                            $("#room_hidden_id").val(data.id);
                           
                        }
                    });
                });

                //get Room data
                $(document).ready(function() {
                    $('#room_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getroombookingData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "guest.name" },
                            { "data": "guest.phone" },
                            { "data": "guest.phone"},
                            { "data": "arrival"},
                            { "data": "departure"},
                            {
                                data: 'status',
                                name: 'status',
                                render: function ( data, type, full, meta ) {
                                    return data==1 ? "<label class='label label-success'> Available </label>" : data==0 ? "<label class='label label-danger'> Not Available </label>" : "" ;
                                }
                            },
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush