@push('header-assets')
    <link href="{{ URL::asset('assets/vendor/fastselect/css/build.min.css') }}" rel="stylesheet">
    {{--<link rel="stylesheet" href="https://rawgit.com/dbrekalo/attire/master/dist/css/build.min.css">--}}
    <script src="https://rawgit.com/dbrekalo/attire/master/dist/js/build.min.js"></script>

    <link href="{{ URL::asset('assets/vendor/fastselect/css/fastselect.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('assets/vendor/fastselect/js/fastselect.standalone.js') }}"></script>

    <style>

        .fstElement { font-size: .7em;border-radius:5px; }
        .fstToggleBtn { min-width: 16.5em; }
        .fstMultipleMode { display: block; }
        .fstMultipleMode .fstControls { width: 100%; }


    </style>

    <script type="text/javascript">//for images
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#profile-img").change(function(){
            readURL(this);
        });
    </script>
@endpush

<div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Edit Menu</h4>
            </div>
            {!! Form::open(['route' => 'menu.update', 'enctype' => 'multipart/form-data']) !!}
            {{ csrf_field() }}
            <div class="modal-body" style="overflow-x: hidden;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="menu_nam" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="nick_name">Nick Name</label>
                            <input type="text" name="nick_name" id="nickn" placeholder="Enter Menu Nick Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('nick_name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="descript" placeholder="Enter Description" class="form-control">
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="text" name="cost" id="costrate" placeholder="Enter Cost" class="form-control">
                            <span class="text-danger">{{ $errors->first('cost') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="pricreate" placeholder="Enter Cost" class="form-control">
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Menu Category</label>
                            <select class="multicontrol" id="editmultipleSele" multiple name="menu_category[]">
                                @foreach($menucategories as $menucategory)
                                    <option value="{{ $menucategory->id }}">{{ $menucategory->name }}</option>
                                @endforeach
                                <span class="text-danger">{{ $errors->first('menu_category') }}</span>
                            </select>
                            {{--<button class="submitBtn" type="submit">Submit</button>--}}

                        </div>

                        <div class="form-group">

                            <label for="price">Products</label>
                            <select class="form-control" id="editmulti" multiple name="product[]">
                                @foreach($products as $product)
                                    <option selected="" value="{{ $product->id  }}">{{ $product->name }}</option>
                                @endforeach

                            </select>
                            {{--<button class="submitBtn" type="submit">Submit</button>--}}

                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="discount">Discount</label>
                                <input type="text" name="discount" id="discountrate" placeholder="Enter Discount" class="form-control">
                                <span class="text-danger">{{ $errors->first('discount') }}</span>
                            </div>
                            <div class="col-md-4">
                                <label>Discount Type</label>
                                {!! Form::select('discount_type', getDiscountStatus() , null, ["class" => "form-control"])!!}
                                <small class="text-danger">{{ $errors->first('discount_type') }}</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="tax">Tax</label>
                                <input type="text" name="tax" id="tax" placeholder="Enter Tax" class="form-control">
                                <span class="text-danger">{{ $errors->first('tax') }}</span>
                            </div>
                            <div class="col-md-4">
                                <label>Tax Type</label>
                                {!! Form::select('tax_type', getTaxStatus() , null, ["class" => "form-control"])!!}
                                <small class="text-danger">{{ $errors->first('tax_type') }}</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            {!! Form::select('status', getAvailableStatus() , null, ["class" => "form-control"])!!}
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Image</label>
                            <input type="file" name="menu_photo" id="profile-img">
                            <p class="help-block">Insert Images.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Add Menu</button>
            </div>
            {!! Form::close() !!}
        </div>


    </div>
</div>
<script>

$('#editmultipleSele').fastselect();
$('#editmulti').fastselect();

</script>


