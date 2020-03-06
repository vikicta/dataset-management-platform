@extends('layouts.admin')

@section('content')
    {{-- Error message --}}
    @include('layouts.error_messages')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-dark">Upload Dataset</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="dataset">Dataset</label>
                    <input type="file" class="form-control" name="dataset" value="{{ old('dataset') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
