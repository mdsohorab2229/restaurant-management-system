@if($orders)
<div class="order-items">
    <input type="hidden" value="{{ session('get_reorder_sound') }}" id="reorder_session_sound">
    @foreach($orders as $key => $order)
        <div class="re-order" data-toggle="modal" data-target="#details_modal" id="{{ $order->id }}">
            <div class="order-item-content">
                <h2>Order No: <strong id="order">{{ $order->order_no }}</strong></h2>
                <h3>Waiter: <strong id="order_waiter">{{ $order->user->name }}</strong></h3>
                <h3>Table: <strong id="order_table">{{ $order->table->name }}</strong></h3>
            </div>
        </div>
    @endforeach                        
</div>

@endif