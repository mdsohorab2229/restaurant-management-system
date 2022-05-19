@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">

        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Product Category</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="productCategory_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                </table>
                @include('productcategories.create_product_category')
                @include('productcategories.edit_product_category')
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
                    var category_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("productcategories/edit") }}',
                        method: "POST",
                        data: {category_id:category_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.name);
                            $("#category_hidden_id").val(data.id);
                        }
                    });
                });

                //get productCategory data
                $(document).ready(function() {
                    $('#productCategory_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getProductCategoryData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            { "data": "action" }
                        ]
                    });
                });
            });

        }(jQuery));

    </script>
@endpush