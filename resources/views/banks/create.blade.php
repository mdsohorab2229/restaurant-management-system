<div class="modal fade" id="add" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Bank Money</h4>
            </div>
            {!! Form::open(['route' => 'bankmoney.store']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            {!! Form::select('bank_name', makeDropDown($banklists),null,["class" => "form-control select2", "style" => "width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('bank_name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category Type</label>
                            {!! Form::select('category', getBankType(),null,["class" => "form-control select2", "style" => "width:100%"])!!}
                            <small class="text-danger">{{ $errors->first('category') }}</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="asset" placeholder="Enter Amount" class="form-control">
                            <span class="text-danger">{{ $errors->first('amount') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="submited_date">Date</label>

                            <div class="input-group date">
                                <input type="text" name="submited_date" placeholder="Enter Date" class="form-control pull-right date-picker" id="datepicker">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <span class="text-danger">{{ $errors->first('submited_date') }}</span>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter Desciption ..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            {!! Form::select('status', getStatus() , null, ["class" => "form-control"])!!}
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                        </div>
                    </div>
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


        }(jQuery));
    </script>

@endpush