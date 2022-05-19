<div class="modal fade" id="add_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Discount Card</h4>
                
            </div>
            {!! Form::open(['route' => 'discountcard.store']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label>Customer</label>
                    <span data-toggle="modal" data-target="#add_customer" class="btn btn-xs btn-default pull-right bg-red">Add Customer</span>
                    {!! Form::select('customer', makeDropDown($customers, 'id', 'customer_phone'),null,["class" => "form-control select2", "style" => "width:100%"])!!}
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                </div>
                


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Card Number</label>
                            <input type="number" name="cardnumber" id="" placeholder="Enter card number" class="form-control">
                            <span class="text-danger">{{ $errors->first('cardnumber') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Discount %</label>
                            <input type="number" name="discount" min="1" max="100" id="myPercent" placeholder="%" class="form-control">
                            <span class="text-danger">{{ $errors->first('discount') }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="departure">Expire Date</label>
    
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="expiredate" class="form-control pull-right date-picker" id="datepicker">
                      <span class="text-danger">{{ $errors->first('expiredate') }}</span>
                    </div>
                    <!-- /.input group -->
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>
  @push('footer-scripts')
   <!-- date-range-picker -->
   <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
   <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>

  <script>
        (function ($) {
            "use strict";

            $('.date-picker').datepicker({
                        format: "yyyy-mm-dd",
                        autoclose: true,
                        todayHighlight: true,
                    }); 
        

        }(jQuery));
    </script>

  @endpush