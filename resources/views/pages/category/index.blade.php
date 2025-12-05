@extends('layouts.main')

@section('content')
<div class="container">

        <h2>Category Records</h2>

        <a href="{{ route('category.create') }}" class="btn btn-primary">Create New</a>

        <table class="table table-bordered">

        <thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Actions</th>
</tr>
</thead>
<tbody>

        @foreach($items as $item)
<tr>

        <td>{{ $item->id }}</td>
<td>{{ $item->name }}</td>
<td>

        <a href="{{ route('category.edit', $item->id) }}" class="btn btn-info">Edit</a>

        <button class="btn btn-danger deleteItem" data-id="{{ $item->id }}">Delete</button>

        </td>
</tr>
@endforeach
</tbody>
</table>

        </div>
@endsection

        @push('script')

        <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


            $('body').on('click', '.deleteItem', function () {
                var item_id = $(this).data("id");
                swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('admin/category') }}" + '/' + item_id,
                            success: function (data) {
                                // Reload the table or remove the row
                                location.reload(); // Option 1: Reload page
                                // Option 2: Remove row without reload
                                // $('tr[data-id="' + item_id + '"]').remove();
                                toastr.options.timeOut = 5000;
                                toastr.success("Record has been deleted");
                            },
                            error: function (response) {
                                toastr.options.timeOut = 5000;
                                toastr.success("Record has been deleted");
                                location.reload(); 
                            }
                        });
                    }
                });
            });
        </script>

        @endpush