@extends('layouts.hotel-master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')

    <div class="jrr-class">

        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Booking Room</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="room_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Booking No</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Room</th>
                        <th>Arrival</th>
                        <th>Departure</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roombookings as $key => $roombooking)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $roombooking->booking_no }}</td>
                        <td> {{ $roombooking->guest->name }} </td>
                        <td> {{ $roombooking->guest->phone }} </td>

                        <td>
                            @if($roombooking->bookingRooms)
                            <ul class="custom-list">
                                @foreach($roombooking->bookingRooms as $bookRoom)
                                    <li>{{ $bookRoom->room->floor  }}->{{ $bookRoom->room->room_no  }}-> {{ $bookRoom->room->roomCategory->name  }}</li>
                                @endforeach
                            </ul>
                            @endif

                        </td>

                        <td> {{ $roombooking->arrival }} </td>
                        <td> {{ $roombooking->departure }} </td>
                        <td>
                            <a href="{{ route('roombooking.edit', $roombooking->id)  }}}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                            {!! Form::open(['route' => ['roombooking.destroy', $roombooking->id], 'method' => 'DELETE', 'class'=>'inline-el']) !!}
                            <button type="submit" class="btn btn-danger btn-xs" onclick="deleteSwal(this, event)" data-toggle="tooltip" title="Delete" data-placement="top"> <i class="fa fa-trash"></i> </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>
                @include('hotel.roombooking.create')

            </div>
            <div class="box-footer"></div>
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