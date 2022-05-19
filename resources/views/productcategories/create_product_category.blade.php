<div class="modal fade" id="add_modal"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Product Category</h4>
            </div>
            {!! Form::open(['route' => 'product_category.store']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="product_category" placeholder="Enter Category Name" class="form-control">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>