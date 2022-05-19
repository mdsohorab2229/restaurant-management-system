<div class="modal fade" id="edit_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Edit Units</h4>
            </div>
            {!! Form::open(['route' => 'units.update']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter Unit Name" class="form-control">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                    <input type="hidden" name="unit_id" id="unit_hidden_id" value="">
                </div>
                <div class="form-group">
                    <label for="name">shortname</label>
                    <input type="text" name="shortname" id="shortname" placeholder="Enter Unit Short Name" class="form-control">
                    <span class="text-danger">{{ $errors->first('shortname') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                 
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>