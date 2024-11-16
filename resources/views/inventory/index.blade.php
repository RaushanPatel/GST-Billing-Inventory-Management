@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventory</h1>
    <a href="{{ route('inventory.create') }}" class="btn btn-primary">Add New Product</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventory as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->product_quantity }}</td>
                    <td>&#8377; {{ $product->product_price }}</td>
                    <td>
                        <a href="{{ route('inventory.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('inventory.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-between mt-3">
        <div></div> <!-- Empty div to balance alignment -->
        <div>
            {{ $inventory->links('pagination::bootstrap-4') }} <!-- Bootstrap 4 pagination style -->
        </div>
        <div></div> <!-- Empty div to balance alignment -->
    </div>
</div>
@endsection
