@php $header = 'Products > Edit Product'; @endphp
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

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{$product->name}}">
        </div>
        <div class="mb-3">
            <label>SKU:</label>
            <input type="text" name="sku" class="form-control" value="{{$product->SKU}}" disabled>
        </div>
        <div class="mb-3">
            <label>Price:</label>
            <input type="number" name="price" class="form-control" value="{{$product->price}}" step="0.01">
        </div>
        <div class="mb-3">
            <label>Quantity:</label>
            <input type="number" name="quantity" class="form-control" value="{{$product->quantity}}">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
