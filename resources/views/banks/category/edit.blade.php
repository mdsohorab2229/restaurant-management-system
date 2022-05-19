<div class="modal fade" id="edit_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Edit Category </h4>
            </div>
            {!! Form::open(['route' => 'bankcategory.update']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Category Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            {!! Form::select('status', getStatus() , null, ["class" => "form-control", "id" => "status"])!!}
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                            <input type="hidden" name="bankcategory_id" id="bankcategory_hidden_id" value="">
                        </div>
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