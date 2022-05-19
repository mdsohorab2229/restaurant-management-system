<div class="modal fade" id="add_modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Role</h4>
            </div>
            {!! Form::open(['route' => 'role.store', 'method' => 'post']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Role Name</label>
                    <input type="text" name="name" id="" placeholder="Enter role name" class="form-control">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Display Name</label>
                    <input type="text" name="display_name" id="" placeholder="Enter display name" class="form-control">
                    <span class="text-danger">{{ $errors->first('display_name') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Role Name</label>
                    <input type="text" name="description" id="" placeholder="Enter Description" class="form-control">
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Save Role</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>