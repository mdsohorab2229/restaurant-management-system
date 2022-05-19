@extends('layouts.hotel-master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')

<div class="jrr-class">
        
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">All Guest</h3>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
        </div>
        <div class="box-body">
            <table class="table table-bordered" id="guest_table" width="100%">
                <thead>
                <tr class="bg-success">
                    <th>#</th>
                    <th>Name</th>
                    <th>Occupation</th>
                    <th>Phone</th>
                    <th>District</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
            @include('hotel.guest.create')
            @include('hotel.guest.edit')
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
                    var guest_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("guest/edit") }}',
                        method: "POST",
                        data: {guest_id:guest_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            
                            $("#na").val(data.name);
                            $("#occupation").val(data.occupation);
                            $("#organiza").val(data.organization);
                            $("#organizatio_address").val(data.organization_address);
                            $("#emai").val(data.email);
                            $("#phon").val(data.phone);
                            $(".datebirt").val(data.birthdate);
                            $("#inentit").val(data.identity_no);
                            $("#dist").val(data.district_id);
                            $("#addrs").val(data.address);
                            $("#guest_hidden_id").val(data.id);
                           
                        }
                    });
                });

                //get guest data
                $(document).ready(function() {
                    $('#guest_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getguestData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            {
                                data: 'occupation',
                                name: 'occupation',
                                render: function ( data, type, full, meta ) {
                                    return data==0 ? "Student" : data==1 ? "Govt Service" : data==2 ? "Private Service" : data==3 ? " Busness " :data==4 ?" Others " : "";
                                }
                            },
                            { "data": "phone" },
                            {"data": "district.name"},
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush