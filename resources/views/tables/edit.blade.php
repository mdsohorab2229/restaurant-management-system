<div class="modal fade" id="edit_modal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Edit Table</h4>
                </div>
                {!! Form::open(['route' => 'table.update']) !!}
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter table Name" class="form-control">
                        <input type="hidden" name="table_id" id="table_hidden_id">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Nickname</label>
                        <input type="text" name="nickname" id="nickname" placeholder="Enter nickname" class="form-control">
                        <span class="text-danger">{{ $errors->first('nickname') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Capaity</label>
                        <input type="number" name="capacity" id="capacity"  placeholder="Enter Capacity" class="form-control">
                        <span class="text-danger">{{ $errors->first('capacity') }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Save Changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
      </div>