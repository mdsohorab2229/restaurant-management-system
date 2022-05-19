@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div id="ams-class">

        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Users</h3>
                @if(Auth::user()->canDo('manage_admin'))
                <a href="{{ route('users.create') }}" class="btn btn-danger add-new-btn">Add New</a>
                @endif

                    <div class="box-tools">
                        {!! Form::open(['route' => 'users.search', 'method' => 'GET']) !!}
                        {{ csrf_field() }}
                        <div class="input-group input-group-sm" style="width: 180px;">
                            <input type="text" name="user_search" class="form-control pull-right" placeholder="Enter Search Item" required>

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                {{-- search field --}}
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if($users->count())
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th style="width: 15px">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            @if(Auth::user()->canDo('manage_admin'))
                                <th>Action</th>
                            @endif
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td style="width: 10px">{{ (++$loop->index) }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->role()->name }}</td>
                                <td class="text-center">
                                    @if($user->status == 1)
                                        <label class="label label-success">{{ getStatus($user->status) }}</label>
                                    @else
                                        <label class="label label-warning">{{ getStatus($user->status) }}</label>
                                    @endif
                                </td>

                                @if(Auth::user()->canDo('manage_admin'))
                                    <td class="text-center">
                                        <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-xs btn-primary" title="Edit" data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a>

                                        {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE', 'class'=>'inline-el']) !!}
                                        <button type="submit" class="btn btn-danger btn-xs"
                                                onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete"
                                                data-placement="top">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                @endif

                            </tr>
                        @endforeach

                    </table>

                    <div>
                        No class yet to show. You can easily <a href="{{ route('users') }}">View All User</a>.
                    </div>

                @else()
                    <div style="color:black" class="alert alert-danger alert-dismissible col-md-6">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Sorry!</strong> No Item Found.
                    </div>
                    {{--<div>--}}
                        {{--No class yet to show. You can easily <a href="{{ route('users.create') }}">create one</a>.--}}
                    {{--</div>--}}
                @endif
                    <div class="pull-right">
                        {{ $users->links() }}
                    </div>
            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.box -->

    </div>
@endsection
{{--// content section --}}