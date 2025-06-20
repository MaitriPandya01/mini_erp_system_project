@php $header = 'Dashboard'; @endphp
@extends('layouts.app')
<style>
.gradient-card{
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    border: none;
    color: white;
}
.gradient-card-1{
    background: linear-gradient(135deg,rgb(200, 78, 78),rgb(214, 183, 183));
    border: none;
    color: white;
}
.gradient-card-2{
    background: linear-gradient(135deg,rgb(78, 200, 78), rgb(214, 234, 214));
    border: none;
    color: white;
}
</style>
@section('content')
@if ($lowStockProducts->count())
    <div class="alert alert-warning">
        <strong>⚠️ Low Stock Alert:</strong>
        <ul class="mb-0">
            @foreach ($lowStockProducts as $product)
                <li>
                    {{ $product->name }} (SKU: {{ $product->SKU }}) has only <strong>{{ $product->quantity }}</strong> in stock.
                </li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container mt-4">
    <div class="row">

        <!-- Sales Orders Count -->
        <div class="col-md-4">
            <div class="card text-white gradient-card bg-primary mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Sales Orders</h5>
                    <p class="card-text fs-4">{{ $totalOrders??'0' }}</p>
                </div>
            </div>
        </div>

        <!-- Confirmed Orders -->
        <div class="col-md-4">
            <div class="card text-white  gradient-card-1 bg-success mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Confirmed Orders</h5>
                    <p class="card-text fs-4">{{ $confirmedOrders??'0' }}</p>
                </div>
            </div>
        </div>

        <!-- Total Sales Amount -->
        <div class="col-md-4">
            <div class="card text-white gradient-card-2 bg-dark mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Sales Amount</h5>
                    <p class="card-text fs-4">₹{{ number_format($totalSales??'0', 2) }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

