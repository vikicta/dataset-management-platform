@extends('layouts.admin')

@section('content')
    {{-- Error message --}}
    @include('layouts.error_messages')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-dark">Edit Task</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('task.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $task->name }}" required>
                </div>
                <div class="form-group">
                    <label for="name">Annotator</label>
                    <select name="annotator_id" class="form-control select2">
                        <option></option>
                        @foreach ($annotators as $annotator)
                            <option value="{{ $annotator->id }}" {{$annotator->id == $task->annotator_id ? 'selected' : ''}}>{{ $annotator->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="dataset">Dataset ({{ $task->dataset_name }})</label>
                    <input type="file" class="form-control" name="dataset" value="{{ old('dataset') }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select a Annotator",
            allowClear: true
        });
    });
</script>

@endpush
