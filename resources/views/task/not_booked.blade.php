@extends('layouts.admin')

@section('content')

{{-- Alert --}}
@include('sweetalert::alert')

<h1 class="h3 mb-2 text-dark">Tasks</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-nowrap text-dark" id="taskTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Booked By</th>
                        <th>Dataset</th>
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
        var datatables = $('#taskTable').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            scrollX: true,
            ajax: '{{ route("annotator.task.not.booked.datatables") }}',
            order: [[ 3, "desc" ]],
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'annotator.name',
                    name: 'annotator.name',
                    defaultContent: '',
                },
                {
                    data: 'dataset_name',
                    name: 'dataset_name'
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
        $(document).on('click', '.book', function (ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
            swal.fire({
                title: "Book this?",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                showLoaderOnConfirm: true,
                closeOnConfirm: false,
            })
            .then((result) => {
                if (result.value) {
                    window.location.href = urlToRedirect;
                }
            });
        });
        // EO Delete alert

    });

</script>
@endpush
