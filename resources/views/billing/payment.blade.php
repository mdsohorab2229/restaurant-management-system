<div class="modal fade" id="make_payment" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width:60vw">
        <div class="modal-content">
            <div class="modal-header" style="background:#dd4b39;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" style="color:white;">Order No: <span id="display_order_no"></span></h4>
            </div>
            {{ Form::open(['route' => 'billing.create']) }}
            {{ csrf_field() }}
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
                                    <input type="number" min="1" name="deposit" class="form-control" id="depositmoney" onkeyup="forDue()" placeholder="Enter amount" required>
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
                                        <input type="number" min="0" step="0.01" id="discount" placeholder="i.e. 10%" class="form-control" value="0" onkeyup="forDue()">
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
                            
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="background:#9e9e9e">
                <button type="submit" class="btn btn-danger" onclick="submit_form(this, event)" disabled>Process Bill</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>


@push('footer-scripts')
    <script type="text/javascript"> //for due money
            function forDue() {
                var total = parseFloat(document.getElementById("remainingval").value);
                var val2 = parseInt(document.getElementById("depositmoney").value);
                var discount = parseInt(document.getElementById("discount").value);
                discount = (isNaN(discount) ? 0 : discount);
                val2 = (isNaN(val2) ? 0 : val2);
                // to make sure that they are numbers
                if (!total) { total = 0; }
                if (!val2) { val2 = 0; }
                var ansD = document.getElementById("due");
                ansD.value = total - (val2+discount);
            };

        (function ($) {
            "use strict";

            /*at document loading time*/
            jQuery(document).ready(function ($) {
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

                //for submit button desable
              $('#depositmoney').keyup(function () {
                    if ($(this).val().length > 0) {
                        $('button[type=submit]').prop('disabled', false);
                    } else {
                        $('button[type=submit]').prop('disabled', true);
                    }
                
                });

                //event on change discount type
                $(document).on('keyup change', '#discount, input:radio[name=discount_type]', function(){
                    var discount = parseFloat($('#discount').val());
                    discount = (isNaN(discount) ? 0 : discount);
                    var discount_type = $('input:radio[name=discount_type]:checked').val();
                    var total_amount = parseFloat($('#total_amount').val());
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