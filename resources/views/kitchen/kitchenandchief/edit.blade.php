<div class="modal fade" id="edit_modal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Edit Kitchen & Chief</h4>
                </div>
                {!! Form::open(['route' => 'kitchenchief.update']) !!}
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kitchen</label>
                        {!! Form::select('kitchen', makeDropDown($kitchens),null,["class" => "form-control", "id"=>"kitchen", "style" => "width:100%"])!!}
                        <span class="text-danger">{{ $errors->first('kitchen') }}</span>
                    </div>
                    <div class="form-group">
                        <label>Chief</label>
                        {!! Form::select('user_id', makeDropDown($users),null,["class" => "form-control", "id"=>"userr", "style" => "width:100%"])!!}
                        <span class="text-danger">{{ $errors->first('user_id') }}</span>
                    </div>
                    <input type="hidden" name="kitchenchief_id" id="kitchenchief_hidden_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Save</button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
      </div>