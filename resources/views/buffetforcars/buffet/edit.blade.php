<div class="modal fade" id="edit_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Edit</h4>
            </div>
            {!! Form::open(['route' => 'buffetcars.buffetlistupdate']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Car/Company Name</label>
                            {!! Form::select('name',makeDropDown($buffetcars) , null, ["id" => "name","class" => "form-control", "style"=>"width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Car Number</label>
                            <input type="text" name="carnumber" id="carnumber" placeholder="Enter Car Number" class="form-control">
                            <span class="text-danger">{{ $errors->first('carnumber') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Supervisor Name</label>
                            <input type="text" name="supervisorname" id="suervisorname" placeholder="Enter Supervisor Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('phone1') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Phone</label>
                            <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" class="form-control">
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
                                    <input type="text" name="arrivaltime" id="arrivaltime" class="form-control timepicker">

                                </div>
                                <!-- /.input group -->
                                <span class="text-danger">{{ $errors->first('arrivaltime') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">From</label>
                            <input type="text" name="from" id="from" placeholder="Enter where From" class="form-control">
                            <span class="text-danger">{{ $errors->first('from') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="amount">Total Payable</label>
                                <input type="number" name="amount" id="totalpay" class="form-control totalpayable" onkeyup="forDueamount()">
                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="paidamount">Paid Amount</label>
                                <input type="number" name="paidamount" id="totaldeposit" class="form-control paidamount" onkeyup="forDueamount()">
                                <span class="text-danger">{{ $errors->first('paidamount') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="due">Due</label>
                                <input type="number" name="due" id="totaldue" class="form-control dueamount" readonly>
                                <span class="text-danger">{{ $errors->first('due') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment">Discription:</label>
                    <textarea class="form-control" name="discription" id="discription" placeholder="Enter Discription" rows="2" id="comment"></textarea>
                    <span class="text-danger">{{ $errors->first('discription') }}</span>
                    <input type="hidden" name="buffet_id" id="car_hidden_id" value="">
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


    <script>
        function forDueamount() {
            var total = parseFloat(document.getElementById("totalpay").value);
            var val2 = parseInt(document.getElementById("totaldeposit").value);
            // to make sure that they are numbers
            if (!total) { total = 0; }
            if (!val2) { val2 = 0; }
            var ansD = document.getElementById("totaldue");
            ansD.value = total - val2;
        };

    </script>

@endpush
