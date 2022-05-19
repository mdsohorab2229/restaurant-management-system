<div class="modal fade" id="guestPayment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Payment</h4>
            </div>
            {!! Form::open(['route' => 'hotel.guest.payment', 'method' => 'post']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Select Guest</label>
                            {!! Form::select('guest', makeDropDown($guestList, 'id', 'guest_phone') , null, ["class" => "form-control select2", "id" => "guest_id", "style" => "width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('guest') }}</span>  
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Payment Date</label>
                            <input type="text" name="payment_date" placeholder="yyyy-mm-dd" class="form-control date-picker" autocomplete="off">
                            <span class="text-danger">{{ $errors->first('payment_date') }}</span>  
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Payment Method</label>
                            {!! Form::select('payment_method', getPaymentMethod(), null, ["class" => "form-control", "id" => "payment_method"])!!}
                            <span class="text-danger">{{ $errors->first('payment_method') }}</span>  
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" id="transaction_no" >
                        <div class="form-group">
                            <label for="">Transcation No</label>
                            <input type="text" name="transaction" id="" placeholder="Enter Transaction Number" class="form-control">
                            <span class="text-danger">{{ $errors->first('transaction') }}</span> 
                        </div>
                    </div>
                    <div class="col-md-6" id="card_no">
                        <div class="form-group">
                            <label for="">Card No</label>
                            <input type="text" name="card" id="" placeholder="Enter Card Number" class="form-control">
                            <span class="text-danger">{{ $errors->first('card') }}</span> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="guest_payement"></div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Comments</label>
                        <textarea name="comments" class="form-control" placeholder="Comments............." style="height:120px"></textarea>
                        <span class="text-danger">{{ $errors->first('comments') }}</span>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Payment Submit</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('footer-scripts')
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>
    <script>
        (function ($) {
            "use strict";

            jQuery(document).ready(function ($) {
                
                $(document).on('change', '#guest_id', function() {
                    var guest_id = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ url('hotel/guest/payment') }}",
                        method: 'POST',
                        data: {guest_id:guest_id, _token:_token},
                        //dataType:"json",
                        success: function(data) {
                            $('#guest_payement').html(data);
                        }
                    });
                })
            });

            $('.date-picker').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true
            });

            //Bkash & Rocket View
            $('#transaction_no').hide();
            $(document).on('change', '#payment_method', function() {
                var type = $(this).val();
                if(type=='bkash' || type=='rocket') {
                    $('#transaction_no').show();
                }
                    else {
                    $('#transaction_no').hide();
                }
            
            });
            //card view
            $('#card_no').hide();
            $(document).on('change', '#payment_method', function() {
                var type = $(this).val();
                if(type=='card') {
                    $('#card_no').show();
                }
                    else {
                    $('#card_no').hide();
                }
                
            });

            //calculation discount
            $(document).on('keyup', '#_discount', function() {
                var discount = parseInt($(this).val());
                var paid = parseInt($('#_paid').val());
                if(isNaN(discount)){
                    discount = 0;
                }
                if(isNaN(paid)){
                    paid = 0;
                }
                var subtotal = parseInt($('#_subtotal').val());
                var vat = parseInt($('#_vat').val());
                var total_amount = subtotal-discount+vat;                
                var due = total_amount-paid;
                $('#_due').val(due);
                $('#_total').val(total_amount);
            });

            //calculation paidamount
            $(document).on('keyup', '#_paid, #_total', function() {
                var paid = parseInt($(this).val());
                if(isNaN(paid)){
                    paid = 0;
                }
                var total = parseInt($('#_total').val());
                var total_amount = total - paid;
                $('#_due').val(total_amount);
            });

        }(jQuery));
    </script>
@endpush