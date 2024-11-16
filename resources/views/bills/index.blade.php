@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>All Bills</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Application</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
                <tr>
                    <td>{{ $bill->id }}</td>
                    <td>{{ $bill->application->title }}</td>
                    <td>{{ $bill->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('bills.show', ['application' => $bill->application_id, 'bill' => $bill->id]) }}" class="btn btn-primary">View Invoice</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
