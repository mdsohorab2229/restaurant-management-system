@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="ems-class">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Roles</h3>
                        <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success"  data-toggle="modal" data-target="#add_modal" >Add new</a>
                    </div>
                    <div class="box-body">
                        @if($roles)
                        <table class="table table-bordered">
                            <tr class="bg-gray">
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        {!! Form::open() !!}
                                            {{ csrf_field() }}
                                            <button type="button" name="edit_data" id="{{ $role->id }}" class="btn btn-xs btn-primary edit_data"  data-toggle="modal" data-target="#edit_modal"><i class="fa fa-edit"></i></button>
                                        {!! Form::close() !!}
                                        
                                        {!! Form::open(['route' => ['role.destroy', $role->id], 'method' => 'DELETE', 'class'=>'inline-el']) !!}
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>
                                        {!! Form::close() !!}

                                        {!! Form::open() !!}
                                            {{ csrf_field() }}
                                            <button type="button" name="permission_set" id="{{ $role->id }}" class="btn btn-xs btn-warning edit_permission"  data-toggle="modal" data-target="#permission_edit"><i class="fa fa-edit"></i> Permission</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                            @else
                            //no Products Found
                        @endif
                    </div>
                    <div class="box-footer"></div>
                </div>
            </div>
        </div>

        @include('roles.create')
        @include('roles.edit')
        @include('roles.permission')

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
                    var role_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("role/edit") }}',
                        method: "POST",
                        data: {role_id:role_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#role_name").val(data.name);
                            $("#display_name").val(data.display_name);
                            $("#description").val(data.description);
                            $("#role_hidden_id").val(data.id);
                        }
                    });
                });


                //edit permission
                $(document).on('click', '.edit_permission',function() {
                    var role_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("role/permission") }}',
                        method: "POST",
                        data: {role_id:role_id, _token : _token},
                        success:function(data){
                            $('#permission').html(data);
                        }
                    });
                });
                
            });
            
        
            
        }(jQuery));
    </script>
@endpush