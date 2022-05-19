<div class="modal fade" id="add" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Asset</h4>
            </div>
            {!! Form::open(['route' => 'assetlist.store']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="asset" placeholder="Enter Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            {!! Form::select('category', makeDropDown($assetcategories),null,["class" => "form-control select2", "style" => "width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('category') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Total Price</label>
                            <input type="number" name="price" id="asset" placeholder="Enter Price" class="form-control">
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purchase_date">Purchase Date</label>

                            <div class="input-group date">
                                <input type="text" name="purchase_date" placeholder="Enter Date" class="form-control pull-right date-picker" id="datepicker">
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
                            <input type="number" name="quantity" id="quantity" placeholder="Enter Price" class="form-control">
                            <span class="text-danger">{{ $errors->first('quantity') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter Desciption ..."></textarea>
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
@push('footer-scripts')
    <!-- date-range-picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-timepicker/css/timepickerr.min.css') }}">
    <script src="{{ asset("bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js") }}"></script>


    <script>
        (function ($) {
            "use strict";

            $('.date-picker').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
            });
            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            });


        }(jQuery));
    </script>

@endpush