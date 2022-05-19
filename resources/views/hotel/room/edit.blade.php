<div class="modal fade" id="edit_modal">
    <div class="modal-dialog" style="width:60vw">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Update Room</h4>
            </div>
            {!! Form::open(['route' => 'room.update']) !!}
            {{ csrf_field() }}
            <div class="modal-body" style="overflow-x: hidden;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Floor</label>
                            <input type="text" name="floor" id="floo" placeholder="Enter floor" class="form-control">
                            <span class="text-danger">{{ $errors->first('floor') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="room_no">Room Number</label>
                            <input type="text" name="room_no" id="room_number" placeholder="Enter room number" class="form-control">
                            <span class="text-danger">{{ $errors->first('room_no') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="room_name">Room Name</label>
                            <input type="text" name="room_name" id="room_nam" placeholder="Enter room name" class="form-control">
                            <span class="text-danger">{{ $errors->first('room_name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="room_type">Room Type</label>
                            {!! Form::select('room_type',makeDropDown($room_categories) , null, ["id" => "room_typ","class" => "form-control", "style"=>"width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('room_type') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="capacity">Capacity</label>
                            <input type="number" min="1" name="capacity" id="capacit" placeholder="Enter capacity" class="form-control">
                            <span class="text-danger">{{ $errors->first('capacity') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Status</label>
                                {!! Form::select('status',[null => 'Select Activity'] + getAvailableRoomStatus() , null, ["id" => "statu","class" => "form-control"])!!}
                                <small class="text-danger">{{ $errors->first('status') }}</small>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">

                                <label>Description</label>
                                <textarea name="description" id="descriptio" class="form-control" rows="3" placeholder="Enter Desciption ..."></textarea>

                            </div>
                            <input type="hidden" name="room_id" id="room_hidden_id">

                        </div>
                    </div>

                </div>

            <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update</button>
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
                    }); 
      

        }(jQuery));
    </script>

  @endpush