<table class="table table-hover results table-sm sortable">
    <!-- Add a switch column in your table -->
    <thead style="border-radius:10px;" class="text-center">
        <tr>
            <th>Move</th>
            <th>S.NO</th>
            <th>Image</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody style="background-color:white;" class="text-center" wire:sortable="updateTaskOrder">
        @foreach($banners as $ban)
        <tr wire:sortable.item="{{ $ban->id }}" wire:key="ban-{{ $ban->id }}">
            <td wire:sortable.handle style="width: 10px; cursor: move;"><i class="fa fa-arrows-alt text-muted"></i></td>
            <td>{{$loop->iteration}}</td>
            <td>
                @php
                    $extension = pathinfo($ban->image, PATHINFO_EXTENSION);
                @endphp
                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                    <!-- Display image -->
                    <img src="{{ asset($ban->image) }}" style="height: 90px; width: 160px;" alt="">
                @else
                    <video src="{{ asset($ban->image) }}" style="height: 90px; width: 160px;" alt=""></video>
                @endif
            </td>
            </td>
            <td>
                <div class="prashanth">
                    <label class="switch switch-left-right">
                        <input class="switch-input myCheckbox" data-id="{{$ban->id}}"  {{$ban->active ? 'checked' : ''}} type="checkbox" >
                        <span class="switch-label" data-on="On" data-off="Off"></span> <span
                            class="switch-handle"></span> </label>
                </div>

                </div>
            </td>
            <td><a data-attr="{{$ban->id}}" id="mediumButton" class="btn btn-danger btn-sm" style="cursor: pointer;"><i
                        class="text-white fa fa-trash"></i></a>
                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$ban->id}}" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-pen"></i></a>
                    
                    </td>
        </tr>
        @endforeach
    </tbody>


</table>



<script>
    // Wait for the document to be ready
    $(document).ready(function () {
        var checkbox = $('.myCheckbox');

        checkbox.change(function () {
            if ($(this).is(':checked')) {
                ajaxCall('on', $(this).data('id'));
            } else {
                ajaxCall('off', $(this).data('id'));
            }
        });

        // Function to make the Ajax call
        function ajaxCall(state, dataId) {
            $.ajax({
                type: 'GET',
                url: '/admin/banner-status/'+state+"/"+dataId,
                success: function (data) {
                    toastr.options.timeOut = 5000;
                    toastr.success(data.success);
                },
                error: function (error) {
                    toastr.options.timeOut = 5000;
                    toastr.error("Try again");
                }
            });
        }

    });
</script>
