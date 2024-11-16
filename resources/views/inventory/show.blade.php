@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Product Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text"><strong>Quantity Available:</strong> {{ $product->quantity }}</p>
            <p class="card-text"><strong>Price:</strong> &#8377;{{ $product->price }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('inventory.index') }}" class="btn btn-primary">Back to Inventory</a>
        </div>
    </div>
</div>
@endsection

