<div class="modal fade" id="add_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Discount Card</h4>
                
            </div>
            {!! Form::open(['route' => 'discountlist.discountstore']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label>Customer</label>
                    {!! Form::select('customer', makeDropDown($customers),null,["class" => "form-control select2", "style" => "width:100%"])!!}
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                </div>

                <div class="form-group">
                    <label>Car Number</label>
                    <select name="carnumber" class="form-control select2" style="width: 100%;">
                        <option value="" selected="selected" required>Select Number</option>
                        @foreach($discountcards as $discountcard)
                        <option value="{{$discountcard->id}}">{{$discountcard->cardnumber}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('carnumber') }}</span>
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