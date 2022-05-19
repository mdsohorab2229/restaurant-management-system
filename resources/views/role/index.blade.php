@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="ems-class">

        <div class="row">
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Products</h3>
                        <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success"  data-toggle="modal" data-target="#add_modal" >Add new</a>
                    </div>
                    <div class="box-body">
                        @if($roles)
                        <table class="table table-bordered">
                            <tr class="bg-gray">
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Display Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>
                                        {!! Form::open() !!}
                                        {{ csrf_field() }}
                                        <button type="button" name="edit_data" id="{{ $role->id }}" class="btn btn-xs btn-primary edit_data"  data-toggle="modal" data-target="#edit_modal"><i class="fa fa-edit"></i></button>
                                        {!! Form::close() !!}
                                        
                                        {!! Form::open(['route' => ['role.destroy', $role->id], 'method' => 'DELETE', 'class'=>'inline-el']) !!}
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>
                                        {!! Form::close() !!}

                                        <a href="" class="btn btn-xs btn-success"><i class="fa fa-cog"></i> Set Permission</a>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                            @else
                            //no Roles Found Found
                        @endif
                    </div>
                    <div class="box-footer"></div>
                </div>
            </div>
        </div>

        @include('role.create')
        @include('role.edit')

    </div>
@endsection
{{--// content section --}}

{{-- push footer --}}
@push('footer-scripts')
    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/ 
            jQuery(document).ready(function ($) {
                
                $(document).on('click', '.edit_data',function() {
                    var product_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("products/edit") }}',
                        method: "POST",
                        data: {product_id:product_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.name);
                            $("#product_hidden_id").val(data.id);
                            $("#status").val(data.status);
                        }
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush