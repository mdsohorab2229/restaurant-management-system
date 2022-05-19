@extends('layouts.master')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">All Buffet</h3>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add_modal" class="pull-right btn btn-danger btn-sm">Add New</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="buffet_table" width="100%">
                    <thead>
                    <tr class="bg-success">
                        <th>#</th>
                        <th>Bus Name</th>
                        <th>Car Number</th>
                        <th>Supervisor Name</th>
                        <th>Phone</th>
                        <th>Arrival Time</th>
                        <th>From</th>
                        <th>Amount</th>
                        <th>Paid Amount</th>
                        <th>Due</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                </table>
                @include('buffetforcars.buffet.create')
                @include('buffetforcars.buffet.edit')
            </div>
            <div class="box-footer"></div>
        </div>
    </div>

    
@endsection
{{--// content section --}}

{{-- push footer --}}
@push('footer-scripts')
    <script>
        function forDue() {
            var total = parseFloat(document.getElementById("amount").value);
            var val2 = parseInt(document.getElementById("depositmoney").value);
            // to make sure that they are numbers
            if (!total) { total = 0; }
            if (!val2) { val2 = 0; }
            var ansD = document.getElementById("due");
            ansD.value = total - val2;
        };
        (function ($) {
            "use strict";

            /*at document loading time*/ 
            jQuery(document).ready(function ($) {
                
                $(document).on('click', '.edit_data',function() {
                    var buffetcar_id = $(this).attr('id');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ url("buffetcars/buffetlistedit") }}',
                        method: "POST",
                        data: {buffetcar_id:buffetcar_id, _token : _token},
                        dataType:"json",
                        success:function(data){
                            $("#name").val(data.buffetcar_id);
                            $("#suervisorname").val(data.supervisor_name);
                            $("#carnumber").val(data.car_number);
                            $("#phone").val(data.phone);
                            $("#arrivaltime").val(data.arrival_time);
                            $("#from").val(data.from);
                            $(".totalpayable").val(data.amount);
                            $(".paidamount").val(data.paid_amount);
                            $(".dueamount").val(data.due);
                            $("#discription").val(data.discription);
                            $("#car_hidden_id").val(data.id);

                        }
                    });
                });

                //get car/buffet data
                $(document).ready(function() {
                    $('#buffet_table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('ajaxdata.getBuffetData') }}",
                        "columns":[
                            { "data": "serial" },
                            { "data": "buffetcar.name" },
                            { "data": "car_number" },
                            { "data": "supervisor_name" },
                            { "data": "phone" },
                            { "data": "arrival_time" },
                            { "data": "from" },
                            { "data": "amount" },
                            { "data": "paid_amount" },
                            { "data": "due" },
                            { "data": "action" }
                        ]
                    });
                });
                
            });


            
        }(jQuery));

    </script>
@endpush