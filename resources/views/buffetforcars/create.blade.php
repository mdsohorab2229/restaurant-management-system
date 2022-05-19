<div class="modal fade" id="add_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Car & Company</h4>
            </div>
            {!! Form::open(['route' => 'buffetcars.store']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Car/Company Name</label>
                    <input type="text" name="name" id="" placeholder="Enter Company/Car Name" class="form-control">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="comment">Address:</label>
                    <textarea class="form-control" name="address" placeholder="Enter Company Address" rows="3" id="comment"></textarea>
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Phone 1</label>
                    <input type="text" name="phone1" id="" placeholder="Enter Phone Number" class="form-control">
                    <span class="text-danger">{{ $errors->first('phone1') }}</span>
                </div> 
                <div class="form-group">
                    <label for="name">Phone 2</label>
                    <input type="text" name="phone2" id="" placeholder="Enter Phone Number" class="form-control">
                    <span class="text-danger">{{ $errors->first('phone2') }}</span>
                </div> 
                <div class="form-group">
                    <label for="name">Phone 3</label>
                    <input type="text" name="phone3" id="" placeholder="Enter Phone Number" class="form-control">
                    <span class="text-danger">{{ $errors->first('phone3') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Amount</label>
                    <input type="text" name="amount" id="" placeholder="Enter amount" class="form-control">
                    <span class="text-danger">{{ $errors->first('phone3') }}</span>
                </div>
            </div>

                
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>