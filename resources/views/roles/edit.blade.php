<div class="modal fade" id="edit_modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Update Role</h4>
            </div>
            {!! Form::open(['route' => 'role.update']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Role Name</label>
                    <input type="text" name="name" id="role_name" placeholder="Enter role name" class="form-control">
                    <input type="hidden" name="role_hidden_id" id="role_hidden_id">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Display name</label>
                    <input type="text" name="display_name" id="display_name" placeholder="enter display name" class="form-control">
                    <span class="text-danger">{{ $errors->first('display_name') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Description</label>
                    <input type="text" name="description" id="description" placeholder="Enter description" class="form-control">
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update Product</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>