@extends('layouts.main')

@section('content')
<div class="container">

        <h2>Aboutitems Records</h2>

        <a href="{{ route('aboutitems.create') }}" class="btn btn-primary">Create New</a>

        <table class="table table-bordered">

        <thead>
<tr>
<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Content</th>
<th>Actions</th>
</tr>
</thead>
<tbody>

        @foreach($items as $item)
<tr>

        <td>{{ $item->id }}</td>

                    @php
                        // Get file extension
                        $fileExtension = pathinfo($item->image, PATHINFO_EXTENSION);
                        
                        // Determine file type
                        $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
                        $isVideo = in_array($fileExtension, ['mp4', 'webm', 'ogg']);
                    @endphp
                
                    @if($isImage)
                        <td><img src="{{ $item->image }}" style="height: 50px; object-fit: cover;" /></td>
                    @elseif($isVideo)
                        <td>
                            <video width="100" height="50" controls>
                                <source src="{{ $item->image }}" type="video/{{ $fileExtension }}">
                                Your browser does not support the video tag.
                            </video>
                        </td>
                    @else
                        <td>{{ $item->image }}</td>
                    @endif
                <td>{{ $item->title }}</td>
<td>{{ $item->content }}</td>
<td>

        <a href="{{ route('aboutitems.edit', $item->id) }}" class="btn btn-info">Edit</a>

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
                            url: "{{ url('admin/aboutitems') }}" + '/' + item_id,
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