<div class="modal fade" id="add_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Menu</h4>
            </div>
            {!! Form::open(['route' => 'menu.store', 'enctype' => 'multipart/form-data']) !!}
            {{ csrf_field() }}
            <div class="modal-body" style="overflow-x: hidden;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Menu Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="nick_name">Nick Name</label>
                            <input type="text" name="nick_name" id="nick_name" placeholder="Enter Menu Nick Name" class="form-control">
                            <span class="text-danger">{{ $errors->first('nick_name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" placeholder="Enter Description" class="form-control">
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="text" name="cost" id="cost" placeholder="Enter Cost" class="form-control">
                            <span class="text-danger">{{ $errors->first('cost') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price" placeholder="Enter Cost" class="form-control">
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="menu_category">Menu Category</label>
                            <select class="form-control  select2" multiple="multiple" data-placeholder="Select a State"
                            style="width: 100%;"  name="menu_category[]">
                                @foreach($menucategories as $menucategory)
                                <option value="{{ $menucategory->id }}">{{ $menucategory->name }}</option>
                                @endforeach
                                    <span class="text-danger">{{ $errors->first('menu_category') }}</span>
                            </select>
                            {{--<button class="submitBtn" type="submit">Submit</button>--}}
                        </div>

                        <div class="form-group">
                            <label for="price">Products</label>
                            <select class="form-control  select2" multiple="multiple" data-placeholder="Select a State"
                            style="width: 100%;" name="product[]">
                                @foreach($products as $product)
                                <option value="{{ $product->id  }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            {{--<button class="submitBtn" type="submit">Submit</button>--}}
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="discount">Discount</label>
                                    <input type="text" name="discount" id="discount" placeholder="Enter Discount" class="form-control">
                                    <span class="text-danger">{{ $errors->first('discount') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Discount Type</label>
                                    {!! Form::select('discount_type', getDiscountStatus() , null, ["class" => "form-control"])!!}
                                    <small class="text-danger">{{ $errors->first('discount_type') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kitchen</label>
                            {!! Form::select('kitchen', makeDropDown($kitchens),null,["class" => "form-control select2", "style" => "width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('kitchen') }}</span>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            {!! Form::select('status', getAvailableStatus() , null, ["class" => "form-control"])!!}
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Image</label>
                            <input type="file" name="menu_photo" id="menuImage">
                            <p class="help-block">Insert Images.</p>
                            <img src="" alt="" id="menu_image" class="img-circle" style="width: 100px;height:100px;margin-top: 20px">
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

  @push('footer-scripts')
    <script>
        (function ($) {
            "use strict";
            /*at document loading time*/ 
            jQuery(document).ready(function ($) {

                function readURL(input) {

                    if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#menu_image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#menuImage").change(function() {
                    readURL(this);
                });

                
                
            });
            
            
        }(jQuery));
    </script>
@endpush



