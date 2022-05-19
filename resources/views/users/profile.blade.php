@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div id="ams-class">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="/assets/images/avatar-male.png" alt="User profile picture">

                        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                        <p class="text-muted text-center">{{ Auth::user()->email }}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="pull-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="pull-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="pull-right">13,287</a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">About Me</h3>
                    </div>

                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">

                        <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                        <li class="active"><a href="#settings" data-toggle="tab">Change Password</a></li>
                    </ul>
                    <div class="tab-content">

                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">
                            <!-- The timeline -->

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane active" id="settings">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="card">

                                            <div class="card-body">
                                                @if (session('error'))
                                                    <div class="alert alert-danger">
                                                        {{ session('error') }}
                                                    </div>
                                                @endif
                                                @if (session('success'))
                                                    <div class="alert alert-success">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif
                                                <form class="form-horizontal" method="POST" action="{{ route('users.changePassword') }}">
                                                    {{ csrf_field() }}

                                                    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                                        <label for="new-password" class="col-md-4 control-label">Current Password</label>

                                                        <div class="col-md-6">
                                                            <input id="current-password" type="password" class="form-control" name="current-password" required>

                                                            @if ($errors->has('current-password'))
                                                                <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                                        <label for="new-password" class="col-md-4 control-label">New Password</label>

                                                        <div class="col-md-6">
                                                            <input id="new-password" type="password" class="form-control" name="new-password" required>

                                                            @if ($errors->has('new-password'))
                                                                <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="new-password-confirm" class="col-md-4 control-label">Confirm New Password</label>

                                                        <div class="col-md-6">
                                                            <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-6 col-md-offset-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                Change Password
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>

    </div>
@endsection
{{--// content section --}}