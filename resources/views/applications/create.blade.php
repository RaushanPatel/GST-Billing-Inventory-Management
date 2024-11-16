@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Create Application</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('applications.store') }}" method="POST" onsubmit="return validateForm()">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    // Form validation function
    function validateForm() {
        // Get the value of the description field
        var description = document.getElementById('description').value;

        if (!description.trim()) {
            alert('Description field is required');
            return false; // Prevent form submission if description is empty
        }
        return true; // Allow form submission if description is filled
    }
</script>
@endsection
