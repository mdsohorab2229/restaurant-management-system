@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Edit menu</h3>
            </div>
            {!! Form::open(['route' => ['menu.update', $menu->id], 'enctype' => 'multipart/form-data', 'method' => 'post']) !!}
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="menu_nam" class="form-control" value="{{ $menu->name }}">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="nick_name">Nick Name</label>
                            <input type="text" name="nick_name" id="nickn" placeholder="Enter Menu Nick Name" class="form-control"  value="{{ $menu->nick_name }}">
                            <span class="text-danger">{{ $errors->first('nick_name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="descript" placeholder="Enter Description" class="form-control" value="{{ $menu->discription }}">
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="text" name="cost" id="costrate" placeholder="Enter Cost" value="{{ $menu->cost }}" class="form-control">
                            <span class="text-danger">{{ $errors->first('cost') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" value="{{ $menu->price }}" name="price" id="pricreate" placeholder="Enter Cost" class="form-control">
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Menu Category</label>
                            <select name="menu_category[]" class="form-control select2" multiple="multiple" data-placeholder="Select a State"
                            style="width: 100%;">
                                @foreach($menucategories as $menucategory)
                                    <option {{ in_array($menucategory->id, $categories) ? "selected" : ""}} value="{{ $menucategory->id }}">{{ $menucategory->name }}</option>
                                @endforeach
                                <span class="text-danger">{{ $errors->first('menu_category') }}</span>
                            </select>
                            {{--<button class="submitBtn" type="submit">Submit</button>--}}

                        </div>

                        <div class="form-group">
                            <label for="price">Products</label>
                            <select class="form-control select2" multiple="multiple" data-placeholder="Select a State"
                            style="width: 100%;" name="product[]">
                                @foreach($menu_products as $product)
                                    <option {{ in_array($product->id, $products) ? "selected" : ""}}  value="{{ $product->id  }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            {{--<button class="submitBtn" type="submit">Submit</button>--}}

                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="discount">Discount</label>
                                <input type="text" name="discount" id="discountrate" placeholder="Enter Discount" class="form-control" value="{{ $menu->discount }}">
                                <span class="text-danger">{{ $errors->first('discount') }}</span>
                            </div>
                            <div class="col-md-4">
                                <label>Discount Type</label>
                                {!! Form::select('discount_type', getDiscountStatus() , $menu->discount_method, ["class" => "form-control"])!!}
                                <small class="text-danger">{{ $errors->first('discount_type') }}</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kitchen</label>
                            {!! Form::select('kitchen', makeDropDown($kitchens),$menu->kitchen_id, ["class" => "form-control", "id"=>"kitchen", "style" => "width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('kitchen') }}</span>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            {!! Form::select('status', getAvailableStatus() , $menu->availability, ["class" => "form-control"])!!}
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Image</label>
                            <input type="file" name="menu_photo" id="menuImage">
                            @if($menu->photo)
                                <img src="{{ asset($menu->photo) }}" alt="" id="menu_image" class="img-circle" style="width: 100px;height:100px;margin-top: 20px">
                                <input type="hidden" name="hidden_image_path" value="{{ $menu->photo }}">
                                @else
                                <img src="" alt="" id="menu_image" class="img-circle" style="width: 100px;height:100px;margin-top: 20px">
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    
@endsection

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
