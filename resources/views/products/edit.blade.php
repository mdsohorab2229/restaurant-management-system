@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Update Raw Materials</h3>
                <a href="{{ url('products/list') }}" class="btn btn-sm btn-success pull-right">View List</a>
            </div>
            {!! Form::open(['route' => ['product.update', $product->id], 'method' => 'post']) !!}
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Product Code</label>
                            <input type="text" name="product_code" value="{{ $product->product_code }}" class="form-control" placeholder="Enter product code">
                            <span class="text-danger">{{ $errors->first('product_code') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" placeholder="Enter product name">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" name="description" class="form-control" value="{{ $product->discription }}"  placeholder="Enter product name">
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Product Category</label>
                            <span data-toggle="modal" data-target="#add_category" class="btn btn-xs btn-default pull-right bg-red">Add Category</span>
                            {!! Form::select('product_category', makeDropDown($categories), $product->product_category_id, ["class" => "form-control", "id" => "category_list"])!!}
                            <span class="text-danger">{{ $errors->first('product_category') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Brand</label>
                            <span data-toggle="modal" data-target="#add_brand"  class="btn btn-xs btn-default pull-right bg-red">Add Brand</span>
                            {!! Form::select('brand', makeDropDown($brands), $product->brand_id, ["class" => "form-control", "id" => "brand_list"])!!}
                            <span class="text-danger">{{ $errors->first('brand') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Supplier</label>
                            <span data-toggle="modal" data-target="#add_supplier"  class="btn btn-xs btn-default pull-right bg-red">Add Supplier</span>
                            {!! Form::select('supplier', makeDropDown($suppliers), $product->supplier_id, ["class" => "form-control", "id" => "supplier_list"])!!}
                            <span class="text-danger">{{ $errors->first('supplier') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="number" class="form-control" value="{{ $product->stock->quantity }}" name="quantity" placeholder="quantity">
                            <span class="text-danger">{{ $errors->first('quantity') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Unit</label>
                            <span data-toggle="modal" data-target="#add_unit" class="btn btn-xs btn-default pull-right bg-red">Add Unit</span>
                            {!! Form::select('unit', makeDropDown($units), $product->stock->unit_id, ["class" => "form-control", "id" => "unit_list"])!!}
                            <span class="text-danger">{{ $errors->first('unit') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cost">Cost per Unit</label>
                            <input type="number" name="cost" class="form-control" id="cost" placeholder="Enter cost per unit" value="{{ $product->cost }}">
                            <span class="text-danger">{{ $errors->first('cost') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            {!! Form::select('status', getStatus() , $product->status, ["class" => "form-control"])!!}
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update Product</button>
            </div>
            {!! Form::close() !!}
        </div>

        {{-- includes blade for add more item (category, brand, supplier) --}}
        @include('products.more.category')
        @include('products.more.brand')
        @include('products.more.supplier')
        @include('products.more.unit')
        
    </div>


@endsection
{{--// content section --}}
