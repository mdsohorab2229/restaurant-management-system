@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Units</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th>Action</th>
                    </tr>
                    @if($units)
                        @foreach ($units as $key => $unit)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $unit->name }}</td>
                                <td>{{ $unit->shortname }}</td>
                                <td>
                                    {!! Form::open() !!}
                                    {{ csrf_field() }}
                                    <button type="button" name="edit_data" id="{{ $unit->id }}" class="btn btn-xs btn-primary edit_data"  data-toggle="modal" data-target="#edit_modal"><i class="fa fa-edit"></i></button>
                                    {!! Form::close() !!}
                                    
                                    {!! Form::open(['route' => ['units.destroy', $unit->id], 'method' => 'DELETE', 'class'=>'inline-el']) !!}
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
                @include('units.create')
                @include('units.edit')
            </div>
            <div class="box-footer"></div>
        </div>
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
                    var unit_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("unit/edit") }}',
                        method: "POST",
                        data: {unit_id:unit_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.name);
                            $("#shortname").val(data.shortname);
                            $("#unit_hidden_id").val(data.id);
                        }
                    });
                });
                
            });
            
        }(jQuery));
    </script>
@endpush