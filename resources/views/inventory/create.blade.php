@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Product</h1>
    <form action="{{ route('inventory.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="product_quantity" class="form-label">Quantity</label>
            <input type="number" name="product_quantity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="product_price" class="form-label">Price</label>
            <input type="number" name="product_price" class="form-control" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
@endsection
