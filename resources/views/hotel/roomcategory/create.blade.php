<div class="modal fade" id="add_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Category</h4>
            </div>
            {!! Form::open(['route' => 'roomcategory.store']) !!}
            {{ csrf_field() }}
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Room Category Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="rate">Rate</label>
                            <input type="text" name="rate" id="rate" placeholder="Enter Room Rate" class="form-control">
                            <span class="text-danger">{{ $errors->first('rate') }}</span>
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