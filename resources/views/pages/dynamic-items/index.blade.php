@extends('layouts.main')
@section('title', 'Page Dynamic Items')

@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>{{ $page->page_name }} - Dynamic Items</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('/')}}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('pages.index') }}">Pages</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dynamic Items
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary mb-3" href="{{ route('pages.dynamic-items.create', $page->id) }}"> 
                Create New Item &nbsp; <i class="fa fa-plus"></i>
            </a>
            
            <div class="card p-3">
                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pages.dynamic-items.index', $page->id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title', name: 'title'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        var deleteId;
        $(document).on('click', '.deleteItem', function(){
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show');
        });

        $('#confirmDelete').click(function(){
            // Generate the base URL and then replace the parameter
            var baseUrl = "{{ route('pages.dynamic-items.destroy', ['page' => $page->id, 'dynamic_page_item' => 'PLACEHOLDER']) }}";
            var url = baseUrl.replace('PLACEHOLDER', deleteId);
            
            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                success: function (data) {
                    $('#deleteModal').modal('hide');
                    table.draw();
                    showNotification('Success', data.success, 'success');
                },
                error: function (data) {
                    $('#deleteModal').modal('hide');
                    showNotification('Error', 'Failed to delete item', 'error');
                }
            });
        });
    });
</script>
@endpush