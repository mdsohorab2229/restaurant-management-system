<div class="modal fade" id="view_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Order No: <span id="order_no"></span></h4>
            </div>
            {{ Form::open() }}
            {{ csrf_field() }}
            <div class="modal-body" id="menuTable">
            </div>
            <div class="modal-footer">
                {{--<button type="submit" class="btn btn-danger">Order Complete</button>--}}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>