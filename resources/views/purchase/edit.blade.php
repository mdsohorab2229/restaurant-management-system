<div class="modal fade" id="edit_modal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Edit Purchase</h4>
                </div>
                {!! Form::open(['route' => 'purchase.update']) !!}
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Select Category</label>
                                {!! Form::select('purchase_category', makeDropdown($categories) , null, ["class" => "form-control"])!!}
                                <small class="text-danger">{{ $errors->first('purchase_category') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" placeholder="Title" class="form-control">
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" id="description" placeholder="Description" class="form-control">
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_date">Purchase Date</label>
                                <input type="text" name="purchase_date" id="e_date" class="form-control">
                                <span class="text-danger">{{ $errors->first('purchase_date') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" name="amount" id="amount" placeholder="Enter amount" class="form-control">
                                <span class="text-danger">{{ $errors->first('amount') }}</span>
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