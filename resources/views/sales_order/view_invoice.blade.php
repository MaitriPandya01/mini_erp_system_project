@php $header='View Invoice'; @endphp
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Sales Invoice  @if(!$order->is_confirmed) - Pending @endif</h5>
             @if($order->is_confirmed)<span class="text-end">#INV-{{ $order->id }}</span>@endif
        </div>

        <div class="card-body">
            <div class="mb-3">
                <strong>Customer:</strong> {{ $order->customer_name }}<br>
                <strong>Order Date:</strong> {{ $order->created_at->format('d M, Y') }}<br>
                <strong>Status:</strong>
                @if($order->is_confirmed)
                    <span class="badge bg-success">Confirmed</span>
                @else
                    <span class="badge bg-secondary">Pending</span>
                @endif
            </div>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->product->SKU }}</td>
                            <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                            <td class="text-end">{{ $item->quantity }}</td>
                            <td class="text-end">₹{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end"><strong>Total:</strong></td>
                        <td class="text-end"><strong>₹{{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
             @if($order->is_confirmed)
            <div class="text-end">
                <a href="{{ route('orders.invoice.pdf', $order->id) }}" class="btn btn-outline-secondary" >Print Invoice</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
