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
                                        <p><span class="taka_sign"> ৳ </span> {{ $menu->price }}</p>
                                        <img src="{{ $menu->photo ? asset($menu->photo) :  'https://previews.123rf.com/images/alexraths/alexraths1509/alexraths150900004/44625664-tarjeta-del-men%C3%BA-de-navidad-para-los-restaurantes-en-el-fondo-de-madera.jpg'}}" alt="">

                                    </div>
                                @endforeach
                            </div>

                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                {!! Form::open(['route' => 'pos-order.billing']) !!}
                {{ csrf_field() }}
                <div class="orders">
                    <div class="order-body">
                        <table class="table table-striped" id="orderedMenu">
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
                                   <td><input type="text" name="vat" value="0.00" class="no-style" id="total_vat" readonly></td>
                               </tr>

                               <tr>
                                   <th>Grand Total</th>
                                   <td><input type="text" name="total" value="0.00" class="no-style" id="total_price" readonly></td>
                               </tr>
                            </table>
                        </div>
                        {{--<a href="{{ route('order.mpdf') }}">view</a>--}}

                        <div class="footer-bt">
                            <span class="jrr-btn jrr-btn-success" id="payment_btn" data-toggle="modal" data-target="#make_payment">Make Payment</span>
                            <a href="#" class="jrr-btn jrr-btn-danger">Cancel</a>
                        </div>
                        <div class="modal fade" id="make_payment" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog" style="width:60vw">
                                <div class="modal-content">
                                    <div class="modal-header" style="background:#dd4b39;">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                        <h4 class="modal-title" style="color:white;">Order No: <span id="display_order_no"></span></h4>
                                    </div>
                                    <div class="modal-body" style="background:#e9e9e9">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-12" style="padding-right: 0px">
                                                        <div class="form-group">
                                                            <label>Customer</label>
                                                            {!! Form::select('customer', makeDropDown($customers, 'id', 'customer_phone'), $setting->customer_id,["class" => "form-control select2", "style" => "width:100%"])!!}
                                                            <span class="text-danger">{{ $errors->first('customer') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Paid Amount</label>
                                                            <input type="number" min="1" name="deposit" class="form-control" id="depositmoney"  placeholder="Enter amount" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding-right:0px">
                                                        <div class="form-group">
                                                            <label>Payment Option</label>
                                                            <select class="form-control" id="payment_type" name="deposit_type" required>
                                                                <option value="">--Type--</option>
                                                                <option value="0">Cash</option>
                                                                <option value="1">Check</option>
                                                                <option value="2">Bkash</option>
                                                                <option value="3">Rocket</option>
                                                                <option value="4">Card</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12" id="transaction_no"  style="padding-right:0px">
                                                        <div class="form-group">
                                                            <label for="">Transcation No</label>
                                                            <input type="text" name="transaction" id="" placeholder="Enter Transaction Number" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" id="card_no"  style="padding-right:0px">
                                                        <div class="form-group">
                                                            <label for="">Card No</label>
                                                            <input type="text" name="card" id="" placeholder="Enter Card Number" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="discount_card">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Discount Card Number</label>
                                                            <input type="text" name="discount_card" id="" class="form-control" placeholder="Enter Discount Card">
                                                            <span class="text-danger">{{ $errors->first('discount_card') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding-right: 0px">
                                                        <div class="form-group">
                                                            <label>Customer</label>
                                                            {!! Form::select('discount_customer', makeDropDown($customers, 'id', 'customer_phone'), null,["class" => "form-control select2", "style" => "width:100%"])!!}
                                                            <span class="text-danger">{{ $errors->first('discount_customer') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="default_discount">Discount</label>
                                                            <div class="input-group">
                                                                <input type="number" min="0" step="0.01" id="discount" placeholder="i.e. 10%" class="form-control" value="0">
                                                                <input type="hidden" name="discount" value="0" id="discount_value">
                                                                <span title="check for fixed" class="input-group-addon" style="padding: 0px;">
                                                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                                                        <input type="radio" name="discount_type" value="fixed" id="discount_type_fixed">&nbsp; Fixed
                                                                    </label>
                                                                </span>
                                                                <span title="check for percentage" class="input-group-addon" style="padding: 0px;">
                                                                    <label style="margin-bottom: 0px; font-weight: 400; padding: 6px 12px;">
                                                                        <input type="radio" name="discount_type" id="discount_type_percentage" checked value="percentage">&nbsp; %
                                                                    </label>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" style="padding-right: 0px">
                                                        <div class="form-group">
                                                            <label>Due</label>
                                                            <input type="text" name="due" class="form-control" id="due" placeholder="Due" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="checkbox" name="discount_available" id="check_discount_card_available">
                                                        <label for="check_discount_card_available">Available Discount Card</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <table class="table" id="display_order_item">
                                                    <tr>
                                                        <th>Total Amount</th>
                                                        <td><strong id="total_amount"></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Vat</th>
                                                        <td><strong id="vat"></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Discount</th>
                                                        <td><strong  id="show_discount_amount">0.00</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Grand Total</th>
                                                        <td><strong id="grandTotal"></strong></td>
                                                    </tr>

                                                    <tr>
                                                        <th>Total Quantity</th>
                                                        <td><strong id="total_quantity"></strong></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="background:#9e9e9e">
                                        <button type="submit" class="btn btn-danger" onclick="submit_form(this, event)" disabled>Process Bill</button>
                                    </div>
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
                                    $('#preview_menu_item').append('<tr><td>' + data.name  + '<input type="hidden" value="" id="pre_menu_'+ data.id +'"></td><td><input type="number" class="preview_quantity no-style" name="preview_quantity" readonly value="1"></td><td><input type="number" name="preview_price" readonly class="preview_price no-style" value="' + data.price + '"></td></tr>');
                                } else {
                                    //quantity will increase here
                                    var current_quantity = $('#menu_id_'+menu_id).closest('tr').find('.product_quantity').val();
                                    var menu_price = $('#menu_id_'+menu_id).closest('tr').find('#menu_hidden_price').val();
                                    $('#menu_id_'+menu_id).closest('tr').find('.product_quantity').val(parseInt(current_quantity, 10) + 1);
                                    $('#menu_id_'+menu_id).closest('tr').find('#menu_price').val(parseInt(menu_price) * (parseInt(current_quantity, 10) + 1));

                                    $('#pre_menu_'+menu_id).closest('tr').find('.preview_quantity').val($('#menu_id_'+menu_id).closest('tr').find('.product_quantity').val());

                                    $('#pre_menu_'+menu_id).closest('tr').find('.preview_price').val($('#menu_id_'+menu_id).closest('tr').find('#menu_price').val());


                                }

                            } else {
                                $('#selectedMenu').append('<tr class="menu-row"><td>' + table_row + '</td><td>' + data.name  + '<input type="hidden"  name="menu_id[]" id="menu_id_'+data.id+'" class="order_menu_id" value="' + data.id + '"></td><td style="white-space:nowrap"><button id="sub"><i class="fa fa-minus-circle"></i></button><input min="1" class="product_quantity" type="number" name="quantity[]" value="1"><button id="plus"><i class="fa fa-plus-circle"></i></button></td><td><input type="text" class="price no-style" name="menu_price[]" id="menu_price" value="' + data.price + '"><input type="hidden" id="menu_hidden_price" value="' + data.price +'"></td><td><span class="btn btn-xs btn-danger cancel"><i class="fa fa-times"></i></span></td></tr>');
                                //load into preview modal
                                $('#preview_menu_item').append('<tr><td>' + data.name  + '<input type="hidden" value="" id="pre_menu_'+ data.id +'"></td><td><input type="number" class="preview_quantity no-style" name="preview_quantity" readonly value="1"></td><td><input type="number" name="preview_price" readonly class="preview_price no-style" value="' + data.price + '"></td></tr>');
                            }

                            summationMenuPrice();

                            summationTotalQuantity();

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

                        summationTotalQuantity();
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
                    summationTotalQuantity();
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
                    summationTotalQuantity();
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
                    summationTotalQuantity();
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
                    $('#sub_total').val(sum);
                    $('#total_vat').val(totalVat);
                    $('#total_price').val(total_price);

                    //preview prices
                    $('#pre_sub_total').html($('#sub_total').val());
                    $('#pre_discount_total').html($('#discount').val());
                    $('#pre_total_vat').html($('#total_vat').val());
                    $('#pre_grand_total').html($('#total_price').val());
                    $('#due').val(total_price);
                }

                //Bkash & Rocket View
                $('#transaction_no').hide();
                $(document).on('change', '#payment_type', function() {
                    var type = $(this).val();
                    if(type=='2' || type=='3') {
                        $('#transaction_no').show();
                    }
                     else {
                        $('#transaction_no').hide();
                    }
                });
                //card view
                $('#card_no').hide();
                $(document).on('change', '#payment_type', function() {
                    var type = $(this).val();
                    if(type=='4') {
                        $('#card_no').show();
                    }
                     else {
                        $('#card_no').hide();
                    }

                });

                function summationTotalQuantity()
                {
                    var total_q = 0;
                    $('.product_quantity').each(function(){
                        total_q += parseFloat($(this).val())    ;
                    });

                    let subtotal = $('#sub_total').val();
                    let vat = $('#total_vat').val();
                    let grandTotal =  $('#total_price').val();
                    $('#total_amount').html(subtotal);
                    $('#vat').html(vat);
                    $('#grandTotal').html(grandTotal);
                    $('#total_quantity').html(total_q);
                    $('#due').val(grandTotal);
                }

                //for submit button desable
                $(document).on('keyup','#depositmoney', function(){
                    var paid_amount = parseFloat($('#depositmoney').val());
                    paid_amount = (isNaN(paid_amount) ? 0 : paid_amount);
                    var discount = parseFloat($('#discount').val());                        
                    discount = (isNaN(discount) ? 0 : discount);
                    var total_amount = parseFloat($('#total_price').val());
                    var discount_type = $('input:radio[name=discount_type]:checked').val();
                    if(discount_type == 'fixed') {                        
                        discount = discount;
                    }
                    else if (discount_type == 'percentage') {
                        discount = total_amount * (discount/100);
                    }
                    var total_amount = parseFloat($('#total_price').val());
                    var summationOfDue = total_amount - (paid_amount+discount);

                    $('#due').val(parseFloat(summationOfDue).toFixed(2));

                    if (paid_amount > 0) {
                        $('button[type=submit]').prop('disabled', false);
                    } else {
                        $('button[type=submit]').prop('disabled', true);
                    }
                });

                //calculation with disocunt
                $(document).on('change keyup', '#sub_total', function() {
                    var sub_total = $('#sub_total').val();
                    var discount = $('#discount').val();
                    let sum = parseFloat(sub_total) - parseFloat(discount);
                    $('#total_price').val(sum);
                    //preview prices
                    $('#pre_sub_total').html($('#sub_total').val());
                    $('#pre_discount_total').html($('#discount').val());
                    $('#pre_grand_total').html($('#total_price').val());
                });

                //discount card
                $('#discount_card').hide();
                $(document).on('change', '#check_discount_card_available', function() {
                    if(this.checked){
                        $('#discount_card').slideDown();
                    } else {
                        $('#discount_card').slideUp(200);
                        $('#discount_card').hide();
                    }
                });

                //event on change discount type
                $(document).on('keyup change', '#discount, input:radio[name=discount_type]', function(){
                    var discount = parseFloat($('#discount').val());
                    discount = (isNaN(discount) ? 0 : discount);
                    var discount_type = $('input:radio[name=discount_type]:checked').val();
                    var total_amount = parseFloat($('#total_price').val());
                    var paid_amount = parseFloat($('#depositmoney').val());
                    paid_amount = (isNaN(paid_amount) ? 0 : paid_amount);
                    var due = $('#due').val();
                    if(discount_type == 'fixed') {                        
                        due = total_amount - (paid_amount + (discount));
                        $('#discount_value').val(discount);
                        $('#show_discount_amount').html(discount);
                    }
                    else if (discount_type == 'percentage') {
                        due = total_amount - (paid_amount + parseFloat((total_amount*(discount/100))));
                        $('#discount_value').val(parseFloat(total_amount*(discount/100)));
                        $('#show_discount_amount').html(parseFloat(total_amount*(discount/100)).toFixed(2));
                    }
                    $('#due').val(parseFloat(due).toFixed(2));
                });


            });


        }(jQuery));
    </script>
@endpush
