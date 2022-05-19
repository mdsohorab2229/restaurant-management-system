@extends('layouts/ordering')

{{-- Variables --}}
@section('page_title', $page_title)
@section('page_header', $page_header)
@section('page_desc', $page_desc)

@section('content')
    <div class="jrr-class">
        
        <div class="row">
            <div class="col-md-7">
                <h2 class="order-title">Today's Order</h2>
                <div class="orders-box" id="orders">
                    
                </div>
            </div>
            <div class="col-md-5">
                <h2 class="order-title">Re-Order</h2>
                <div class="orders-box" id="reorders">

                </div>
            </div>
        </div>
        @include('chief.order-detials')
    </div>
    
@endsection

@push('footer-scripts')
<script>
    (function ($) {
        "use strict";

        /*at document loading time*/ 
        jQuery(document).ready(function ($) {
            //for view details orders      
            $(document).on('click', '.order-item', function() {
                var order_id = $(this).attr('id');
                var order_no = $(this).find('#order').text();
                var waiter = $(this).find('#order_waiter').text();
                var order_table = $(this).find('#order_table').text();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url("order/menu/view") }}',
                    method: "POST",
                    data: {order_id:order_id, _token : _token},
                    success:function(data){
                        $('#order_no').html(order_no);
                        $('#waiter_name').html(waiter);
                        $('#table_no').html(order_table);
                        $('#menuTable').html(data);
                        $('#print_link').attr("href", "order/token/"+order_id);
                    }
                });
            });

            //'redirect_newtab'  => route('order.token', $order->id)

            //for served orders      
            $(document).on('click', '.re-order', function() {
                var order_id = $(this).attr('id');
                var order_no = $(this).find('#order').text();
                var waiter = $(this).find('#order_waiter').text();
                var order_table = $(this).find('#order_table').text();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url("order/menu/re-order/view") }}',
                    method: "POST",
                    data: {order_id:order_id, _token : _token},
                    success:function(data){
                        $('#order_no').html(order_no);
                        $('#waiter_name').html(waiter);
                        $('#table_no').html(order_table);
                        $('#menuTable').html(data);
                        $('#print_link').attr("href", "order/reorder-token/"+order_id);
                    }
                });
            });

            //jquery setTimeout
            setInterval(function(){
                var session_sound = $('#session_sound').val();
                if(session_sound == 'on') {
                    notificationSound();
                }
                $('#orders').load('{{ route("load.orders") }}');
                
            }, 5000);

            //jquery setTimeout
            setInterval(function(){
                var session_sound = $('#reorder_session_sound').val();
                if(session_sound == 'on') {
                    notificationSound();
                }

                $('#reorders').load('{{ route("load.re-orders") }}');
            },5000);


            //play  notification sound
            function notificationSound()
            {
                var media = new Audio();
                media.src = '{{ asset('assets/audio/notify.mp3') }}';
                media.play();
                
            }

        });

    }(jQuery));

</script>
@endpush