@php $header = 'Sales Order > Add Order'; @endphp
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Customer Name</label>
        <input name="customer_name" class="form-control" required>
    </div>

    <label>Select Products</label>
    @foreach ($products as $product)
        <div class="mb-2 border p-2">
            <strong>{{ $product->name }}</strong> ({{ $product->quantity }} in stock)
            <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}">
            <input type="number" name="products[{{ $loop->index }}][quantity]" class="form-control mt-1"
                placeholder="Quantity" min="0" max="{{ $product->quantity }}">
        </div>
    @endforeach

    <div class="mb-3">
      <label>Confirmation</label>
      <select name="is_confirmed" class="form-control" required>
        <option value = ""> select choice</option>
        <option value = "1"> Confirmed</option>
        <option value = "0"> Not Confirmed</option>
      </select>
    </div>

    <button class="btn btn-success mt-3">Submit Order</button>
</form>
@endsection


