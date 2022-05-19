<div class="modal fade" id="permission_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Manage Permission</h4>
            </div>
            {!! Form::open(['route' => 'role.permission.set']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div id="permission"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Set Permission</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>