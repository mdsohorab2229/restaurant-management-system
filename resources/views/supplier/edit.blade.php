<div class="modal fade" id="edit_modal"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Update Supplier</h4>
            </div>
            {!! Form::open(['route' => 'supplier.update', 'method' => 'POST']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Name/Company Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            <input type="hidden" name="supplier_id" id="supplier_hidden_id" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Phone</label>
                            <input type="tel" maxlength="14" name="phone" id="phone" placeholder="Enter supplier phone" class="form-control">
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="email" name="email" id="email" placeholder="Enter supplier email" class="form-control">
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Address</label>
                            <input type="text" name="address" id="address" placeholder="Enter supplier address" class="form-control">
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            {!! Form::select('status', getStatus() , null, ["class" => "form-control", "id" => "status"])!!}
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>