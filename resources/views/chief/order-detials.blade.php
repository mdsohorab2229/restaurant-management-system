<div class="modal fade" id="details_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Order No: <span id="order_no"></span></h4>
            </div>
            {{ Form::open(['route' => 'order.prepared', 'method' => 'post']) }}
            {{ csrf_field() }}
            <div class="modal-body" id="menuTable">
            </div>
            <div class="modal-body">
                <p class="pull-left"><strong>Waiter: </strong> <span id="waiter_name"></span></p>
                <p class="pull-right"><strong>Table No: </strong> <span id="table_no"></span></p>
            </div>
            <div class="modal-footer">
                
                <a href="#" target="_blank" class="pull-left btn btn-md btn-success" id="print_link"> <i class="fa fa-print"></i> Print Order</a>
                Order Complete? <button type="submit" class="btn btn-md btn-success" onclick="submit_form(this, event)">Notify to Waiter</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>