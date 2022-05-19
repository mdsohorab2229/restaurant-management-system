<div class="modal fade" id="edit_modal">
    <div class="modal-dialog" style="width:60vw">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Room Booking</h4>
            </div>
            {!! Form::open(['route' => 'roombooking.store', 'enctype' => 'multipart/form-data']) !!}
            {{ csrf_field() }}
            <div class="modal-body" style="overflow-x: hidden;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="guest_name">Guest Name</label>
                                {!! Form::select('guest_id',makeDropDown($guests,'id', 'guest_phone') , null, ["id" => "guestname","class" => "form-control", "style"=>"width:100%"])!!}
                                <span class="text-danger">{{ $errors->first('guest_id') }}</span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="name">Select Room</label>
                                <select class="form-control select2" name="room_id[]" multiple="multiple" data-placeholder="Select Room" style="width: 100%;">

                                    <option value="">---Select Room---</option>

                                    @foreach($rooms as $room)
                                        @if($room->status==1)
                                            <option value="{{$room->id}}"> {{$room->floor}} => {{$room->room_no}} ({{$room->roomcategory->name}}) </option>
                                        @endif
                                    @endforeach

                                </select>
                                <span class="text-danger">{{ $errors->first('district') }}</span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="adult">Adults</label>
                                <input type="number" min="1" name="adult" id="adult" placeholder="Adults" class="form-control">
                                <span class="text-danger">{{ $errors->first('adult') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="children">Children</label>
                            <input type="number" min="0" name="children" id="children" placeholder="Children" class="form-control">
                            <span class="text-danger">{{ $errors->first('children') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="arrival">Arrival Date</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="arrival" class="form-control pull-right date-picker" id="datepicker">
                                    <span class="text-danger">{{ $errors->first('arrival') }}</span>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="departure">Departure Date</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="departure" class="form-control pull-right date-picker" id="datepicker">
                                <span class="text-danger">{{ $errors->first('departure') }}</span>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Check In Time:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" name="checkInTime" class="form-control timepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Check Out Time:</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" name="checkOutTime" class="form-control timepicker">
                            </div>
                            <!-- /.input group -->
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