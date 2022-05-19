@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        {{-- filltering --}}
        <div class="box box-warning filtering">
            <div class="box-header with-border">
                <h3 class="box-title">Filter Report</h3>
            </div>
            <div class="box-body">
                <div class="table">
                    <div class="table-cell">
                        <div class="row">                            
                            {!! Form::open(['route' => 'report.profit', 'method' => 'get']) !!}
                                {{ csrf_field() }}
                                <div class="col-md-2">
                                    <input type="text" name="from_date" class="form-control date-picker" placeholder="From Date" autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="to_date" class="form-control date-picker" placeholder="To Date"  autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    {!! Form::select('menu_name', makeDropdown($all_menus) , null, ["class" => "form-control"])!!}
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-danger"><i class="fa fa-search"></i> Search</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- reports data --}}
        <div class="box box-defaul">
            {{-- <div class="box-header with-border">
                <h3 class="box-title">Stock Report</h3>
            </div> --}}
            <div class="box-body">
                <table class="table table-bordered" id="explodefile">
                    <thead>
                        <tr class="bg-gray">
                            <th>#</th>
                            <th>Menu/Dish</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th>Price</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $key => $menu)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $menu['name'] }}</td>
                                <td>{{ $menu['quantity'] }}</td>
                                <td>{{ $menu['cost'] }}</td>
                                <td>{{ $menu['price'] }}</td>
                                <td>{{ $menu['profit'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer">

                {{ $all_menus->links() }}

            </div>
        </div>

    </div>

@endsection
{{--// content section --}}

@push('footer-scripts')
    {{-- Datepicker Plugin --}}
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js") }}"></script>

    <script>
        (function ($) {
            "use strict";

                 jQuery(document).ready(function ($) {
                    //datapicker
                    $('.date-picker').datepicker({
                        format: "yyyy-mm-dd",
                        autoclose: true
                    }); 
                    //report download with csv
                        $('#explodefile').DataTable( {
                            dom: 'lBfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
                        } );


                });
                
            }(jQuery));
    </script>
@endpush