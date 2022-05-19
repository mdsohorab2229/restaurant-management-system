@if($orders)
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-bell-o"></i>
    <span class="label label-warning">{{ count($orders) }}</span>
</a>
<input type="hidden" value="{{ session('get_sound') }}" id="session_sound">
<ul class="dropdown-menu">
    <li class="header">You have {{ count($orders) }} notifications</li>
    @foreach($orders as $order)
        <li>
            {!! Form::open(['route' => ['waiter.order-confirm', $order->id], 'method' => 'post']) !!}
                <span>Order No: {{ $order->order_no }} Prepared</span>
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <button type="submit" onclick="submit_form(this, event)" class="btn btn-sm btn-info">Confirm</button>
            {!! Form::close() !!}
        </li>
    @endforeach
</ul>
@endif