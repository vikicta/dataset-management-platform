@extends('layouts.admin')

@section('content')
    {{-- Error message --}}
    @include('layouts.error_messages')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-dark">Edit Annotator</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('annotator.update', $annotator->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $annotator->name }}" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username" value="{{ $annotator->username }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password (Opsional)</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
