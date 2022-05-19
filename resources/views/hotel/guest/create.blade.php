<div class="modal fade" id="add_modal">
    <div class="modal-dialog" style="width:60vw">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Guest</h4>
            </div>
            {!! Form::open(['route' => 'guest.store', 'enctype' => 'multipart/form-data']) !!}
            {{ csrf_field() }}
            <div class="modal-body" style="overflow-x: hidden;">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="occupation">Occupation</label>
                            {!! Form::select('occupation',[null => 'Select Occupation'] + getOccupationStatus() , null, ["class" => "form-control"])!!}
                            <small class="text-danger">{{ $errors->first('occupation') }}</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="organization">Company/Institute Name</label>
                            <input type="text" name="organization" id="organization" placeholder="Enter Menu company/institute" class="form-control">
                            <span class="text-danger">{{ $errors->first('organization') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="organization_address">Company/Institute Address</label>
                            <input type="text" name="organization_address" id="organization_address" placeholder="Enter Menu company/institute Address" class="form-control">
                            <span class="text-danger">{{ $errors->first('organization_address') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Enter email" class="form-control">
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" placeholder="Enter phone" class="form-control">
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="identity_no">NID / Passport Number</label>
                            <input type="text" name="identity_no" id="nation_id" placeholder="Enter National/Passport Number" class="form-control">
                            <span class="text-danger">{{ $errors->first('identity_no') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="birthdate">Date of Birth:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="birthdate" class="form-control pull-right date-picker" id="datepicker">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="district">Districts</label>
                            {!! Form::select('district',makeDropDown($districts) , null, ["class" => "form-control select2", "style"=>"width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('district') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Enter Address ..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputFile">Image</label>
                            <input type="file" name="photo" id="profile-img">
                            <p class="help-block">Insert Images.</p>
                        </div>
                    </div>
                    <div class="col-md-6">


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Add Guest</button>
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