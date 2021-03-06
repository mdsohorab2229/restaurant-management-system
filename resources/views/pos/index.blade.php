@extends('layouts/ordering')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('find.menu.category') }}" id="menuCategory" method="post">
                {{ csrf_field() }}
                <div class="categories" id="">

                    @if($menu_categories)
                        @foreach ($menu_categories as $category)
                            <div class="category input-item">
                                <input type="checkbox" name="category[]" value="{{ $category->id }}" id="item_{{ $category->id }}">
                                <label for="item_{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <form action="{{ route('find.menu-item.search') }}" id="menuSearch" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                        <input type="text" name="menu_search_item" id="" class="form-control" aria-describedby="basic-addon1" placeholder="Menu item Search by Keyword">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="menus-area">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="menu menu-success">
                    <div class="menu-body">
                        @if($menus)
                            <div class="menu-items" id="menuItems">
                                @foreach($menus as $menu)
                                    <div class="menu-item bounceIn" id="{{ $menu->id }}">
                                        <h3>{{ $menu->name }}</h3>
                                        {{--  {{ $setting->currency_prefix }}  --}}
                                        <p> <span class="taka_sign"> ??? </span> {{ $menu->price }}</p>
                                        <img src="{{ $menu->photo ? asset($menu->photo) :'https://previews.123rf.com/images/alexraths/alexraths1509/alexraths150900004/44625664-tarjeta-del-men%C3%BA-de-navidad-para-los-restaurantes-en-el-fondo-de-madera.jpg'}}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                {!! Form::open(['route' => 'poscreate.store']) !!}
                {{ csrf_field() }}
                <div class="orders">
                    <div class="order-body">
                        {{--<input type="hidden" name="table_id" value="{{ $table_id }}">--}}
                        <table class="table table-hover table-striped" id="orderedMenu">
                            <thead>
                            <tr class="bg-custom">
                                <th>#</th>
                                <th>Menu/Dish</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-right">Price</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="selectedMenu">

                            </tbody>
                        </table>
                    </div>
                    <div class="order-footer">
                        <div class="footer-account">
                            <table class="table order-bill">
                                <tr>
                                    <th>Sub Total</th>
                                    <td>
                                        <input type="text" name="subtotal" value="0.00" class="no-style" id="sub_total" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Vat ({{ $settings->tax_switch == 'on' ? $settings->tax : 0 }}%)</th>
                                    <td><input type="text" name="vat" value="0.00" class="no-style" id="total_vat" readonly> <input type="hidden" name="discount" value="0.00" class="no-style discount" id="discount"></td>
                                </tr>

                                <tr>
                                    <th>Grand Total</th>
                                    <td><input type="text" name="total" value="0.00" class="no-style" id="total_price" readonly></td>
                                </tr>
                            </table>
                        </div>
                        {{--<a href="{{ route('order.mpdf') }}">view</a>--}}

                        <div class="footer-bt">
                            <button  data-toggle="modal" data-target="#preview_modal"  type="button" class="jrr-btn jrr-btn-success">Make Order</button>
                            <a href="#" class="jrr-btn jrr-btn-danger">Cancel</a>
                        </div>
                        <div class="modal fade" id="preview_modal" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                        <h4 class="modal-title">Preview Order</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="preview_menu_items">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Qauntity</th>
                                                    <th>Price</th>
                                                </tr>
                                                </thead>
                                                <tbody id="preview_menu_item">

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="preview_menu_price">
                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-6">
                                                    <table width="100%" class="footer_calculation">
                                                        <tr>
                                                            <th>Sub-Total: </th>
                                                            <td> <span id="pre_sub_total">0.00</span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Vat: </th>
                                                            <td> <span id="pre_total_vat">0.00</span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Grand Total: </th>
                                                            <td> <span id="pre_grand_total">0.00</span></td>
                                                        </tr>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                        {{--<div class="kitchen-button">--}}
                                            {{--<div class="form-group">--}}

                                                {{--@foreach($kitchens as $kitchen)--}}
                                                    {{--<label class="container" for="kitchen_{{ $kitchen->id  }}">--}}
                                                        {{--<input type="radio" value="{{ $kitchen->id }}" name="kitchen_id" class="flat-red" id="kitchen_{{ $kitchen->id  }}">--}}
                                                        {{--{{ $kitchen->name }}--}}
                                                        {{--<span class="checkmark"></span>--}}
                                                    {{--</label>--}}
                                                {{--@endforeach--}}
                                                {{--<span class="text-danger">{{ $errors->first('kitchen_id') }}</span>--}}

                                            {{--</div>--}}

                                        {{--</div>--}}
                                    </div>
                                    {{--@if(count($kitchens))--}}
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-md btn-success" onclick="submit_form(this, event)"><i class="fa fa-print"></i> Send</button>
                                        </div>
                                    {{--@endif--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

{{-- push footer --}}
@push('footer-scripts')
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')  }}">
    <script src="{{ asset('assets/js/owl.carousel.js')  }}"></script>
    <link href="{{ URL::asset('assets/css/all.css') }}" rel="stylesheet">
    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/
            jQuery(document).ready(function ($) {

                $(document).on('click', '.menu-item', function() {
                    var table_row = $("#selectedMenu tr").length+1;

                    var menu_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("waiter/menu/find") }}',
                        method: 'POST',
                        data: {menu_id:menu_id, _token:_token},
                        dataType:"json",
                        success: function(data) {
                            var arr = [];
                            var _order_menu_id = $('order_menu_id').serialize();
                            if($('order_menu_id')) {
                                $('.order_menu_id').each(function () {
                                    arr.push($(this).val());
                                });
                            }
                            var i;
                            var flag = 0;
                            if(arr.length != 0) {
                                for(i=0;i<=arr.length;i++)
                                {
                                    if(arr[i] == data.id) {
                                        flag=0;
                                        break;
                                    } else {
                                        flag=1;
                                    }
                                }
                                if(flag==1){
                                    $('#selectedMenu').append('<tr class="menu-row"><td>' + table_row + '</td><td>' + data.name  + '<input type="hidden" id="menu_id_'+data.id+'" name="menu_id[]" class="order_menu_id" value="' + data.id + '"></td><td style="white-space:nowrap"><button id="sub"><i class="fa fa-minus-circle"></i></button><input min="1" class="product_quantity" type="number" name="quantity[]" value="1"><button id="plus"><i class="fa fa-plus-circle"></i></button></td><td><input type="text" class="price no-style" name="menu_price[]" id="menu_price" value="' + data.price + '"><input type="hidden" id="menu_hidden_price" value="' + data.price +'"></td><td><span class="btn btn-xs btn-danger cancel"><i class="fa fa-times"></i></span></td></tr>');

                                    //load into preview modal
                                    $('#preview_menu_item').append('<tr><td>' + data.name  + '<input type="hidden" value="" id="pre_menu_'+ data.id +'"></td><td><input type="number" class="preview_quantity no-style" name="preview_quantity" readonly value="1"></td><td><input type="number" name="preview_price" readonly class="preview_price no-style" value="' + data.price +'"></td></tr>');

                                    summationMenuPrice();
                                }
                                else {
                                    //quantity will increase here
                                    var current_quantity = $('#menu_id_'+menu_id).closest('tr').find('.product_quantity').val();
                                    var menu_price = $('#menu_id_'+menu_id).closest('tr').find('#menu_hidden_price').val();
                                    $('#menu_id_'+menu_id).closest('tr').find('.product_quantity').val(parseInt(current_quantity, 10) + 1);
                                    $('#menu_id_'+menu_id).closest('tr').find('#menu_price').val(parseInt(menu_price) * (parseInt(current_quantity, 10) + 1));

                                    $('#pre_menu_'+menu_id).closest('tr').find('.preview_quantity').val($('#menu_id_'+menu_id).closest('tr').find('.product_quantity').val());

                                    $('#pre_menu_'+menu_id).closest('tr').find('.preview_price').val($('#menu_id_'+menu_id).closest('tr').find('#menu_price').val());

                                    summationMenuPrice();

                                }

                            } else {
                                $('#selectedMenu').append('<tr class="menu-row"><td>' + table_row + '</td><td>' + data.name  + '<input type="hidden"  name="menu_id[]" id="menu_id_'+data.id+'" class="order_menu_id" value="' + data.id + '"></td><td style="white-space:nowrap"><button id="sub"><i class="fa fa-minus-circle"></i></button><input min="1" class="product_quantity" type="number" name="quantity[]" value="1"><button id="plus"><i class="fa fa-plus-circle"></i></button></td><td><input type="text" class="price no-style" name="menu_price[]" id="menu_price" value="' + data.price + '"><input type="hidden" id="menu_hidden_price" value="' + data.price +'"></td><td><span class="btn btn-xs btn-danger cancel"><i class="fa fa-times"></i></span></td></tr>');
                                //load into preview modal
                                $('#preview_menu_item').append('<tr><td>' + data.name  + '<input type="hidden" value="" id="pre_menu_'+ data.id +'"></td><td><input type="number" class="preview_quantity no-style" name="preview_quantity" readonly value="1"></td><td><input type="number" name="preview_price" readonly class="preview_price no-style" value="' + data.price + '"></td></tr>');
                                summationMenuPrice();
                            }

                            summationMenuPrice();

                        }
                    });
                });

                //delete confirm selected menu
                $(document).on('click', '.cancel', function() {
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4fa7f3',
                        cancelButtonColor: '#d57171',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((res) => {
                        if(res.value != undefined && res.value){
                            $(this).closest('tr').remove();
                        }
                        summationMenuPrice();
                    });
                });


                //find menu based on category
                $(document).on('change', '#menuCategory', function() {
                    const action = $(this).attr('action');
                    const method = $(this).attr('method');
                    const formData = $(this).serialize();
                    $.ajax({
                        url: action,
                        method: method,
                        data: formData,
                        success: function(data) {
                            $("#menuItems").html(data);
                        }
                    });
                });

                //find menu based on menu name
                $(document).on('change keyup', '#menuSearch', function() {
                    const action = $(this).attr('action');
                    const method = $(this).attr('method');
                    const formData = $(this).serialize();
                    $.ajax({
                        url: action,
                        method: method,
                        data: formData,
                        success: function(data) {
                            $("#menuItems").html(data);
                        }
                    });
                });

                //subtract quantity
                $(document).on('click', '#sub', function(e){
                    e.preventDefault();
                    var value  = $(this).siblings('input').val();
                    var menu_price = $(this).closest('tr').find('#menu_hidden_price').val();
                    if(value > 1) {
                        $(this).siblings('input').val(parseInt(value, 10) - 1);
                        $(this).closest('tr').find('#menu_price').val(parseInt(menu_price) * (parseInt(value, 10)-1));

                        var this_menu_id = $(this).closest('tr').find('.order_menu_id').val();

                        $('#pre_menu_'+this_menu_id).closest('tr').find('.preview_quantity').val($('#menu_id_'+this_menu_id).closest('tr').find('.product_quantity').val());

                        $('#pre_menu_'+this_menu_id).closest('tr').find('.preview_price').val($('#menu_id_'+this_menu_id).closest('tr').find('#menu_price').val());

                    } else {
                        $(this).siblings('input').val(1);
                        $(this).closest('tr').find('#menu_price').val(parseInt(menu_price) * 1);
                    }

                    summationMenuPrice();
                });

                //add quantity
                $(document).on('click', '#plus', function(e){
                    e.preventDefault();
                    var value  = $(this).siblings('input').val();
                    var menu_price = $(this).closest('tr').find('#menu_hidden_price').val();
                    $(this).siblings('input').val(parseInt(value, 10) + 1);
                    $(this).closest('tr').find('#menu_price').val(parseInt(menu_price) * (parseInt(value, 10) + 1));

                    var this_menu_id = $(this).closest('tr').find('.order_menu_id').val();

                    $('#pre_menu_'+this_menu_id).closest('tr').find('.preview_quantity').val($('#menu_id_'+this_menu_id).closest('tr').find('.product_quantity').val());

                    $('#pre_menu_'+this_menu_id).closest('tr').find('.preview_price').val($('#menu_id_'+this_menu_id).closest('tr').find('#menu_price').val());

                    summationMenuPrice();
                });

                //add price based on quantity
                $(document).on('change keyup', 'input[name=\'quantity[]\']', function(){
                    var value  = $(this).val();
                    var menu_price = $(this).closest('tr').find('#menu_hidden_price').val();
                    $(this).closest('tr').find('#menu_price').val(parseInt(menu_price) * (parseInt(value, 10)));

                    var this_menu_id = $(this).closest('tr').find('.order_menu_id').val();

                    $('#pre_menu_'+this_menu_id).closest('tr').find('.preview_quantity').val($('#menu_id_'+this_menu_id).closest('tr').find('.product_quantity').val());

                    $('#pre_menu_'+this_menu_id).closest('tr').find('.preview_price').val($('#menu_id_'+this_menu_id).closest('tr').find('#menu_price').val());

                    summationMenuPrice();
                });

                //a function for summation of price
                function summationMenuPrice() {
                    var sum = 0;
                    $('.price').each(function() {
                        sum += parseFloat($(this).val());
                    });

                    var discount = $('#discount').val();
                    let totalWithVat = sum * @if($settings->tax_switch == 'on') {{  $settings->tax ? $settings->tax : 0 }} @else 0 @endif;
                    let totalVat = totalWithVat / 100;
                    let total_price = (sum + totalVat) - parseFloat(discount, 10);
                    console.log(total_price);
                    $('#sub_total').val(sum);
                    $('#total_vat').val(totalVat);
                    $('#total_price').val(total_price);

                    //preview prices
                    $('#pre_sub_total').html($('#sub_total').val());
                    $('#pre_discount_total').html($('#discount').val());
                    $('#pre_total_vat').html($('#total_vat').val());
                    $('#pre_grand_total').html($('#total_price').val());
                }

                //calculation with disocunt
                $(document).on('change keyup', '#sub_total, #discount', function() {
                    var sub_total = $('#sub_total').val();
                    var discount = $('#discount').val();
                    let sum = parseFloat(sub_total) - parseFloat(discount);
                    $('#total_price').val(sum);
                    //preview prices
                    $('#pre_sub_total').html($('#sub_total').val());
                    $('#pre_discount_total').html($('#discount').val());
                    $('#pre_grand_total').html($('#total_price').val());
                });



            });

        }(jQuery));
    </script>
@endpush
