<div class="modal fade" id="edit_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Edit Asset</h4>
            </div>
            {!! Form::open(['route' => 'assetlist.update']) !!}
            {{ csrf_field() }}
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            {!! Form::select('category', makeDropDown($assetcategories),null,["class" => "form-control", "id" => "category" ,"style" => "width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('category') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Total Price</label>
                            <input type="number" name="price" id="price" placeholder="Enter Price" class="form-control">
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purchase_date">Purchase Date</label>

                            <div class="input-group date">
                                <input type="text" name="purchase_date" id="purchase_dat" placeholder="Enter Date" class="form-control pull-right date-picker" id="datepicker">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <span class="text-danger">{{ $errors->first('purchase_date') }}</span>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="_quantity" placeholder="Enter Price" class="form-control">
                            <span class="text-danger">{{ $errors->first('quantity') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="_discription" class="form-control" rows="3" placeholder="Enter Desciption ..."></textarea>
                            <input type="hidden" name="asset_id" id="asset_hidden_id" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                     
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>