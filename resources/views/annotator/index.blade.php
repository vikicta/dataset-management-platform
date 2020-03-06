@extends('layouts.admin')

@section('content')

{{-- Alert --}}
@include('sweetalert::alert')

<h1 class="h3 mb-2 text-dark">Annotator</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('annotator.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-nowrap text-dark" id="annotatorTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {

        // Datatables
        var datatables = $('#annotatorTable').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            scrollX: true,
            ajax: '{{ route("annotator.all.datatables") }}',
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        // EO Datatables


        // Delete alert
        $(document).on('click', '.delete', function (ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
            swal.fire({
                title: "Delete this?",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                showLoaderOnConfirm: true,
                closeOnConfirm: false,
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url: urlToRedirect,
                        data: {
                            '_token' : '{{ csrf_token() }}',
                            '_method' : 'DELETE'
                        },
                        type: "POST",
                        success: function(res) {
                            datatables.ajax.reload( null, false );
                        }
                    });
                }
            });
        });
        // EO Delete alert

    });

</script>
@endpush
