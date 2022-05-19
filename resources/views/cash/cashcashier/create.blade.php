<div class="modal fade" id="add_modal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Add Cash & Cashier</h4>
                </div>
                {!! Form::open(['route' => 'cashcashier.store']) !!}
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cash</label>
                        {!! Form::select('cash', makeDropDown($cashes),null,["class" => "form-control select2", "style" => "width:100%"])!!}
                        <span class="text-danger">{{ $errors->first('cash') }}</span>
                    </div>
                    <div class="form-group">
                        <label>Cashier</label>
                        {!! Form::select('user_id', makeDropDown($users),null,["class" => "form-control select2", "style" => "width:100%"])!!}
                        <span class="text-danger">{{ $errors->first('user_id') }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Save</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
      </div>