@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Asset</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="assetcategory_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Purchase</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                </table>
                @include('Assets.create')
                @include('Assets.edit')
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
                    var asset_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("assets/editasset") }}',
                        method: "POST",
                        data: {asset_id:asset_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.name);
                            $("#category").val(data.assetcategory_id);
                            $("#price").val(data.price);
                            $("#purchase_dat").val(data.purchase_date);
                            $("#_quantity").val(data.quantity);
                            $("#_discription").val(data.description);
                            $("#asset_hidden_id").val(data.id);
                        }
                    });
                });

                //get productCategory data
                $(document).ready(function() {
                    $('#assetcategory_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getAssetData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            { "data": "assetcategory.name" },
                            { "data": "quantity" },
                            { "data": "price" },
                            { "data": "purchase_date" },
                            { "data": "description" },
                            { "data": "action" }
                        ]
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush