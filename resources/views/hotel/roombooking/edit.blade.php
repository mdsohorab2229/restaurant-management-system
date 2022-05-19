@extends('layouts.hotel-master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')

    <div class="jrr-class">

        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Booking</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            {!! Form::open(['route' => ['roombooking.update',$roombookings->id], 'enctype' => 'multipart/form-data']) !!}
            {{ csrf_field() }}
            <div class="modal-body" style="overflow-x: hidden;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="guest_name">Guest Name</label>
                            <select class="form-control" name="guest_name" data-placeholder="Select Room" style="width: 100%;">
                                <option value="">---Select Guest---</option>
                                @foreach($guests as $guest)

                                        <option {{ $guest->id==$roombookings->guest_id ? "selected" : '' }}  value="{{$guest->id}}"> {{$guest->getGuestPhoneAttribute()}} </option>

                                @endforeach

                            </select>
                            <span class="text-danger">{{ $errors->first('guest_name') }}</span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="name">Select Room</label>
                                <select class="form-control select2" name="room_id[]" multiple="multiple" data-placeholder="Select Room" style="width: 100%;">

                                    <option value="">---Select Room---</option>

                                    @foreach($rooms as $room)
                                        @foreach($bookingroommappings as $bookingroommapping)
                                        @if($room->status==1)
                                            <option {{ $room->id==$bookingroommapping->room->id ? "selected" : '' }} value="{{$room->id}}"> {{$room->floor}} => {{$room->room_no}} ({{$room->roomcategory->name}}) </option>
                                        @endif
                                        @endforeach
                                    @endforeach

                                </select>
                                <span class="text-danger">{{ $errors->first('district') }}</span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="adult">Adults</label>
                                <input type="number" min="1" name="adult" id="adult" placeholder="Adults" value="{{ $roombookings->adults }}" class="form-control">
                                <span class="text-danger">{{ $errors->first('adult') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="children">Children</label>
                            <input type="number" min="0" name="children" id="children" value="{{ $roombookings->children }}" placeholder="Children" class="form-control">
                            <span class="text-danger">{{ $errors->first('children') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="arrival">Arrival Date</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="arrival" value="{{ $roombookings->arrival }}" class="form-control pull-right date-picker" id="datepicker">
                                    <span class="text-danger">{{ $errors->first('arrival') }}</span>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="departure">Departure Date</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="departure" value="{{ $roombookings->departure }}" class="form-control pull-right date-picker" id="datepicker">
                                <span class="text-danger">{{ $errors->first('departure') }}</span>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Check In Time:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" value="{{ $roombookings->in_time }}" name="checkInTime" class="form-control timepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Check Out Time:</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" value="{{ $roombookings->out_time }}" name="checkOutTime" class="form-control timepicker">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update</button>
            </div>
            {!! Form::close() !!}
                @include('hotel.roombooking.create')
        </div>
    </div>

@endsection
{{-- push footer --}}
@push('footer-scripts')

    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/
            jQuery(document).ready(function ($) {

            });

        }(jQuery));
    </script>
@endpush