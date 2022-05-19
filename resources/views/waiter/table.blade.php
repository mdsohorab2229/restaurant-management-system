@extends('layouts/ordering')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        {{-- daily activities --}}
        <div class="section-title">
            <h3>Select Table</h3>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if($tables)
                    <div class="box-tables">
                        @foreach ($tables as $table)
                            <a href="{{ route('table.order', $table->id) }}">
                                <div class="box-table">
                                    <div class="box-table-cell">
                                        <div class="box-table-content">
                                            <p>{{ $table->nickname }}</p>
                                            <h2>{{ $table->name }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    
@endsection

@push('footer-scripts')
    <script>
        (function ($) {
            "use strict";

            /*at document loading time*/ 
            jQuery(document).ready(function ($) {            
                $(document).on('click', '.box-table.active', function() {
                    Swal(
                    'Booked',
                    'The Following Table is Book',
                    'success'
                    )
                });
            });

        }(jQuery)); 
    </script>
@endpush