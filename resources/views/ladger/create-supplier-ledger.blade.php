<div class="modal fade" id="add_modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add New Records</h4>
            </div>
            {!! Form::open(['route' => 'supplier-ladger.store']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Supplier</label>
                            {!! Form::select('supplier', makeDropDown($suppliers) , $setting->supplier_id, ["class" => "form-control select2", "style" => "width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('supplier') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Description</label>
                            <textarea name="description" class="form-control description"></textarea>
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Bill Amount</label>
                            <input type="number" name="amount" id="" placeholder="Enter Total bill amount" class="form-control" value="0">
                            <span class="text-danger">{{ $errors->first('amount') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Paid Amount</label>
                            <input type="number" name="paid_amount" id="" placeholder="Enter paid amount" class="form-control" value="0">
                            <span class="text-danger">{{ $errors->first('paid_amount') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Due Amount</label>
                            <input type="number" name="due_amount" id="" placeholder="Enter due amount" class="form-control" value="0" readonly>
                            <span class="text-danger">{{ $errors->first('due_amount') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" name="date" class="date-picker form-control" placeholder="YYYY-MM-DD">
                            <small class="text-danger">{{ $errors->first('file') }}</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Attached File</label>
                            <input type="file" name="attached_file">
                            <small class="text-danger">{{ $errors->first('file') }}</small>
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