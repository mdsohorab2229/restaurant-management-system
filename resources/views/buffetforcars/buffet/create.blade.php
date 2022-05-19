<div class="modal fade" id="add_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Car & Company</h4>
            </div>
            {!! Form::open(['route' => 'buffetcars.storebuffetcar']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="guest_name">Company/Car Name</label>
                             {!! Form::select('buffetcar_id',makeDropDown($buffetcars) , null, ["class" => "form-control select2", "id" => "companyName", "style"=>"width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('buffetcar_id') }}</span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Car Number</label>
                            <input type="text" name="carnumber" id="" placeholder="Enter Car Number" class="form-control">
                            <span class="text-danger">{{ $errors->first('carnumber') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Supervisor Name</label>
                            <input type="text" name="supervisorname" id="" placeholder="Enter Supervisor Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('phone1') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Phone</label>
                            <input type="text" name="phone" id="" placeholder="Enter Phone Number" class="form-control">
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Arrival Time:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" name="arrivaltime" class="form-control timepicker">

                                </div>
                                <!-- /.input group -->
                                <span class="text-danger">{{ $errors->first('arrivaltime') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">From</label>
                            <input type="text" name="from" id="" placeholder="Enter where From" class="form-control">
                            <span class="text-danger">{{ $errors->first('from') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="amount">Total Payable /=</label>
                                <input type="number" name="amount" id="amount" class="form-control" onkeyup="forDue()">
                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="paidamount">Paid Amount /=</label>
                                <input type="number" name="paidamount" id="depositmoney" class="form-control" onkeyup="forDue()">
                                <span class="text-danger">{{ $errors->first('paidamount') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="due">Due /=</label>
                                <input type="number" name="due" id="due" class="form-control" readonly>
                                <span class="text-danger">{{ $errors->first('due') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment">Discription:</label>
                    <textarea class="form-control" name="discription" placeholder="Enter Discription" rows="2" id="comment"></textarea>
                    <span class="text-danger">{{ $errors->first('discription') }}</span>
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
   <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-timepicker/css/timepickerr.min.css') }}">
   <script src="{{ asset("bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js") }}"></script>
    

  <script>

        (function ($) {
            "use strict";

            $('.date-picker').datepicker({
                        format: "yyyy-mm-dd",
                        autoclose: true,
                        todayHighlight: true,
                    }); 
            //Timepicker
            $('.timepicker').timepicker({
                        showInputs: false
                    });


            //for amount
            $(document).on('change', 'select[name="buffetcar_id"]',function() {
                var buffetcar_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url("buffetcars/buffetcaramount") }}',
                    method: "POST",
                    data: {buffetcar_id:buffetcar_id, _token : _token},
                    dataType:"json",
                    success:function(data){
                        $("#amount").val(data.amount);

                    }
                });
            });


        }(jQuery));
    </script>

  @endpush