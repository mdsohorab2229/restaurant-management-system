{{--
    /**
     * Create User Page
     *
     * @package Academy Management Software
     * @author DataTrix Team
     */
--}}
@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

{{-- content section --}}
@section('content')
    <section id="ams-section" class="row">
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Please fill the information below</h3>
                    <a href="{{ route('users') }}" class="btn btn-danger add-new-btn">View List</a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => ['users.update', $user->id], 'method' => 'put']) !!}
                <div class="box-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control"
                               value="{{ $user->email }}">
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control"
                            placeholder="Enter username" value="{{ $user->username }}">
                        <small class="text-danger">{{ $errors->first('username') }}</small>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Enter user password">
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Enter user password confirmation">
                        <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        {!! Form::select('role', makeDropDown($roles) , $user->role()->id, ["class" => "form-control"])!!}
                        <small class="text-danger">{{ $errors->first('role') }}</small>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        {!! Form::select('status', getStatus() , $user->status, ["class" => "form-control"])!!}
                        <small class="text-danger">{{ $errors->first('status') }}</small>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update User</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box -->
        </div>
    </section>
@endsection
{{--// content section --}}

{{-- Custom footer for vue --}}
@push('footer-scripts')
    <script>

    </script>
@endpush
{{--// Custom footers--}}