<div class="modal fade" id="due_take">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Customer: <span id="customer_name"></span></h4>
            </div>
            {!! Form::open(['route' => 'due.taken']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Current Due</label>
                            <input type="number" name="due" id="current_due" class="form-control" readonly>
                            <span class="text-danger">{{ $errors->first('due') }}</span>
                            <input type="hidden" name="customer_id" id="customer_hidden_id">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="text" name="date" class="form-control date-picker" autocomplete="off" >
                            <span class="text-danger">{{ $errors->first('date') }}</span>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Paid Amount</label>
                            <input type="number" name="paid_amount" class="form-control" id="paid_amount" placeholder="Enter Paid Amount">
                            <span class="text-danger">{{ $errors->first('paid_amount') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Due</label>
                            <input type="number" name="current_due" id="new_due" readonly class="form-control">
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