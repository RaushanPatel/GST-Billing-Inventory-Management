@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Sales Overview</h2>

    <!-- Table for Total Sale in a Day -->
    <div class="mb-4">
        <h3>Total Sales in a Day</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Sale (&#8377;)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailySales as $sale)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($sale->date)->format('d-m-Y') }}</td>
                        <td>&#8377; {{ number_format($sale->total_sale, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Table for Total Sale in a Month -->
    <div class="mb-4">
        <h3>Total Sales in a Month</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Sale (&#8377;)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlySales as $sale)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($sale->month)->format('F Y') }}</td>
                        <td>&#8377; {{ number_format($sale->total_sale, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #007bff;
            padding: 1rem 2rem;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }

        .navbar-custom .nav-link:hover {
            color: #ddd;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
