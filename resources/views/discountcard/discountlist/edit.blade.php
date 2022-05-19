<div class="modal fade" id="edit_" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Edit</h4>
                
            </div>
            {!! Form::open(['route' => 'discountcard.update']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                {{--  <div class="form-group">
                    <label>Customer</label>
                    <span data-toggle="modal" data-target="#add_customer" class="btn btn-xs btn-default pull-right bg-red">Add Customer</span>
                    {!! Form::select('customer', makeDropDown($customers),null,["class" => "form-control select2", "style" => "width:100%"])!!}
                                                
                </div>  --}}

                <div class="form-group">
                    <label for="name">Customer</label>
                    {!! Form::select('name',makeDropDown($customers) , null, ["id" => "customername","class" => "form-control", "style"=>"width:100%"])!!}
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Customer</label>
                    {!! Form::select('name',makeDropDown($discountcards) , null, ["id" => "cardnumber","class" => "form-control", "style"=>"width:100%"])!!}
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>

                <div class="form-group">
                    <label>Car Number</label>
                    <select name="carnumber" class="form-control select2" style="width: 100%;">
                        <option value="" selected="selected" required>Select Number</option>
                        @foreach($discountcards as $discountcard)
                            <option value="{{$discountcard->id}}">{{$discountcard->cardnumber}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('carnumber') }}</span>
                </div>
                <input type="hidden" name="customerdiscount_id" id="customerdiscount" value="">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>