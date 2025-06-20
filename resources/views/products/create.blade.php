@php $header = 'Products > Add Product'; @endphp
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

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="">
        </div>
        <div class="mb-3">
            <label>SKU:</label>
            <input type="text" name="SKU" class="form-control" value="">
        </div>
        <div class="mb-3">
            <label>Price:</label>
            <input type="number" name="price" class="form-control" value="" step="0.01">
        </div>
        <div class="mb-3">
            <label>Quantity:</label>
            <input type="number" name="quantity" class="form-control" value="">
        </div>
        <button class="btn btn-success">Save</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
