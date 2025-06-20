@php $header = 'Orders'; @endphp
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Add Order</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Customer Name</th>
                <th>Price</th>
                <th>Confirmation</th>
                <th width="200">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->total }}</td>
                <td>@if($order->is_confirmed) Yes @else No @endif </td>
                <td>
                    
                        <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="btn btn-sm btn-warning">View</a>
                    @if(!$order->is_confirmed)
                    <a data-order-id="{{$order->id}}" class="btn btn-sm btn-success is_confirm">Confirm</a>
                   
                    @if(isset(auth()->user()->role->name) && (auth()->user()->role->name == 'admin'))
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this non confirmed order?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    @endif
                     @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No orders found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
$(document).on('click','.is_confirm',function(){
    if (!confirm('Are you sure you want to confirm this order?')) return;
    var orderId = $(this).data('order-id');
    
     $.ajax({
        url: `/orders/${orderId}/confirm`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        success: function(data) {
            alert(data.message);
            location.reload();
        },
        error: function(xhr) {
            let msg = xhr.responseJSON?.message || 'Something went wrong.';
            alert('Error: ' + msg);
        }
    });
});
</script>