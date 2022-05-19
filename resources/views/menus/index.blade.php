@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Menu</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="menu_table" width="100%">
                    <thead>
                        <tr class="bg-success">
                            <th>#</th>
                            <th>Name</th>
                            <th>Kitchen Name</th>
                            <th>Cost</th>
                            <th>Price</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                </table>
                @include('menus.create')
                @include('menus.view')
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
                //view menu and product mapping table data for food menu
                $(document).on('click', '.view_data',function() {
                    var menu_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("menu/view") }}',
                        method: "POST",
                        data: {menu_id:menu_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            var menus = data.menus;
                            var categories = data.categories;
                            var products = data.products;
                            if(menus)
                            {
                                if(menus.photo)
                                {
                                    $("#menu_image").html("");
                                    $("#menu_image").append('<img src="{{asset("")}}'+ menus.photo +'" width="140" height="140" border="0" class="img-circle"/>');

                                }
                                else {
                                    $("#menu_image").html("");
                                    $("#menu_image").append('<img src="https://cdn0.iconfinder.com/data/icons/kameleon-free-pack-rounded/110/Food-Dome-512.png" name="food" width="140" height="140" border="0" class="img-circle">');
                                }

                                $("#menu_name").text(menus.name);
                                $("#details").text(menus.discription);
                                $("#nickname").text(menus.nick_name);
                                $("#cos").text(menus.cost);
                                $("#pric").text(menus.price);
                                $("#discoun").text(menus.discount);
                                $("#discoun_metod").text(menus.discount_method);
                                if(menus.discount_method==1)
                                {
                                    $('#discoun_metod').html('');
                                    $("#discoun_metod").append("<label class='label label-success'> Percentage(%) </label>");
                                }
                                else
                                {
                                    $('#discoun_metod').html('');
                                    $("#discoun_metod").append("<label class='label label-warning'> Amount </label>");
                                }
                                if(menus.availability==1)
                                {
                                    $('#status').html('');
                                    $("#status").append("<label class='label label-success'> Available </label>");
                                }
                                else
                                {
                                    $('#status').html('');
                                    $("#status").append("<label class='label label-warning'> Not Available </label>");
                                }

                                // $("#status").text(menus.availability==1)?'Active':'Deactive';
                                // var a = (menus.availability==1)?"Active":"deactive";


                            }
                            if(categories) {
                                $('#category').html('');
                                $('#category').append('<span id="res"> </span>');
                                $.each(categories, function(i,category) {
                                    $(document).find('#res').append(
                                    $("<span class='label label-success' style='margin:2px;font-size:12px;'>").text(category.menu_category.name));

                                });
                            }

                            if (products) {
                                $('#product').html('');
                                $('#product').append('<span id="pro"></span>');
                                $.each(products, function(i,product) {
                                    $(document).find('#pro').append(
                                        $("<span class='label label-success' style='margin:2px;font-size:12px;'>").text(product.product.name));
                                });
                            }



                        }
                    });
                });

                //get productCategory data
                $(document).ready(function() {
                    $('#menu_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getMenuData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "name" },
                            // { "data": "kitchen.name" },
                            {
                                data: 'kitchen.name',
                                name: 'kitchen.name',
                                render: function ( data, type, full, meta ) {
                                    return data==null ? "" : data;
                                }
                            },
                            { "data": "cost" },
                            { "data": "price" },
                            {
                                data: "photo",
                                name: "photo",
                                render: function( data, type, full, meta ) {
                                    if(data) {
                                        return '<img src="{{ asset("")}}' + data + '" style="width:60px;height:60px;border-radius:100%;">';
                                    }
                                    return '<img src="https://cdn0.iconfinder.com/data/icons/kameleon-free-pack-rounded/110/Food-Dome-512.png" name="food_menu" width="60" height="60" border="0" class="img-circle">';
                                }

                            },
                            {
                                data: 'availability',
                                name: 'availability',
                                render: function ( data, type, full, meta ) {
                                    return data==1 ? "<label class='label label-success'> Available </label>" : data==0 ? "<label class='label label-danger'> Unavailable </label>" : "" ;
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