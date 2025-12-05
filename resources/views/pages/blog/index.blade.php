@extends('layouts.main')
@section('title', 'Blogs')


<!-- push external head elements to head -->
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
                        <h5>Blogs List</h5>
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
                            <a href="#">Blogs List</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary mb-3" href="javascript:void(0)" id="createNewProduct"> Create new article &nbsp; <i class="fa fa-plus"></i></a>
            <div class="card p-3">
                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <!-- Dynamic DataTable from jquery -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>







<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="packageForm" name="packageForm" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="item_id" id="item_id">
                        <div class="form-group ">
                            <label for="blog_title" class="col-sm-6 control-label">Blog Title (EN)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="blog_title" name="blog_title"
                                    placeholder="Enter Blog Title" required="true">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="blog_title_ar" class="col-sm-6 control-label">Blog Title (AR)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="blog_title_ar" name="blog_title_ar"
                                    placeholder="Enter Blog Title in arabic" required="true">
                            </div>
                        </div>


                        <x-image-input name="blog_image" columns="col-md-12" value="{{ old('blog_image') }}" id="blog_image" label="Banner image" />
                     

                        <div class="form-group ">
                            <label  class="col-sm-6 control-label">Blog Content (EN)</label>
                            <div class="col-sm-12">
                            <x-ckeditor id="blog_content" name="blog_content" :value="null" />
                            </div>
                        </div>


                        <div class="form-group ">
                            <label class="col-sm-6 control-label">Blog Content (AR)</label>
                            <div class="col-sm-12">
                            <x-ckeditor id="blog_content_ar" name="blog_content_ar" :value="null" />
                            </div>
                        </div>

                        <div class="form-group ">
                        <label for="meta_title" class="col-sm-6 control-label">Meta Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                     required="true">
                            </div>
                        </div>



                        <div class="form-group ">
                        <label for="meta_description" class="col-sm-6 control-label">Meta Description</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="meta_description" name="meta_description"
                                     required="true">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="meta_keywords" class="col-sm-6 control-label">Meta Keywords</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                     required="true">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="meta_author" class="col-sm-6 control-label">Meta Author</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="meta_author" name="meta_author"
                                   required="true">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="meta_robots" class="col-sm-6 control-label">Meta Robots</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="meta_robots" value="index,follow" name="meta_robots"
                                     required="true">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="og_title" class="col-sm-6 control-label">OG Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="og_title" name="og_title"  required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="og_description" class="col-sm-6 control-label">OG Description</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="og_description" name="og_description"  required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="og_image" class="col-sm-6 control-label">OG Image URL</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="og_image" name="og_image"  required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="og_url" class="col-sm-6 control-label">OG URL</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="og_url" name="og_url"  required="true">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="og_type" class="col-sm-6 control-label">OG Type</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="og_type" name="og_type"  required="true">
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="twitter_title" class="col-sm-6 control-label">Twitter Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="twitter_title" name="twitter_title" required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="twitter_description" class="col-sm-6 control-label">Twitter Description</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="twitter_description" name="twitter_description"  required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="twitter_image" class="col-sm-6 control-label">Twitter Image</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="twitter_image" name="twitter_image"  required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="twitter_card" class="col-sm-6 control-label">Twitter Card</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="twitter_card" name="twitter_card"  required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="canonical" class="col-sm-6 control-label">Canonical</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="canonical" name="canonical" required="true">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="og_local" class="col-sm-6 control-label">OG Local</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="og_local" name="og_local" required="true">
                            </div>
                        </div>
                    <div class="conatiner">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger float-right"
                                data-dismiss="modal">close</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
<script type="text/javascript">
    $(function () {
     
        /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('blog.index') }}",
            columns: [
                {title: 'SNO', data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {title: 'Blog Title', data: 'blog_title', name: 'blog_title'},
                {
                    title: 'Status',
                    data: 'status',
                    name: 'status',
                    render: function(data, type, full, meta) {
                        return `
                            <label class="switch global-switch">
                                <input type="checkbox" class="toggle-status" ${data ? 'checked' : ''} data-id="${full.id}" data-url="${'/admin/change-status/blogs/'+full.id}">
                                <span class="slider round"></span>
                            </label>
                        `;
                    }
                },
                {
                    title: 'Blog Image',
                    data: "blog_image",
                    name: "blog_image",
                    render: function(data, type, full, meta) {
                        return '<img src="' + data + '" height="50"/>';
                    }
                },
                {title: 'Action', data: 'action', name: 'action', orderable: false, searchable: false},
            ]

        });

        /*------------------------------------------
        --------------------------------------------
        Click to Button
        --------------------------------------------
        --------------------------------------------*/
        $('#createNewProduct').click(function () {
            $('#packageForm').trigger("reset");
            $('#saveBtn').val("create-product");
            $('#item_id').val('');
            $('#packageForm').trigger("reset");
            $('#modelHeading').html("Create new blog");
            $('#ajaxModel').modal('show');
            $('#saveBtn').html('Save Changes');


            $('input[name="blog_image"]').val(''); 
            $('#preview-blog_image').html('');
    
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editProduct', function () {
            var item_id = $(this).data('id');
            $.get("{{ route('blog.index') }}" + '/' + item_id + '/edit', function (data) {
                $('#modelHeading').html("Edit article");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#item_id').val(data.id);
                $('#blog_title').val(data.blog_title);
                $('#blog_title_ar').val(data.blog_title_ar);
                $('#meta_title').val(data.meta_title);
                $('#meta_description').val(data.meta_description);
                $('#meta_keywords').val(data.meta_keywords);
                $('#meta_author').val(data.meta_author);
                $('#meta_robots').val(data.meta_robots);
                $('#og_title').val(data.og_title);
                $('#og_description').val(data.og_description);
                $('#og_image').val(data.og_image);
                $('#og_url').val(data.og_url);
                $('#og_type').val(data.og_type);
                $('#twitter_title').val(data.twitter_title);
                $('#twitter_description').val(data.twitter_description);
                $('#twitter_image').val(data.twitter_image);
                $('#twitter_card').val(data.twitter_card);
                $('#canonical').val(data.canonical);
                $('#og_local').val(data.og_local);

                $('#preview-blog_image').html(
                    `<div class="position-relative" style="display: inline-block;">
                        <img src="${data.blog_image}" style="height:50px;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute" style="top:0; right:0;" onclick="singleRemoveImage('blog_image')">X</button>
                    </div>`
                );

                CKEDITOR.instances['blog_content'].setData(data.blog_content);
                CKEDITOR.instances['blog_content_ar'].setData(data.blog_content_ar);
                $('#saveBtn').html('Save Changes');
            })
        });

        /*------------------------------------------
        --------------------------------------------
        Create Item
        --------------------------------------------
        --------------------------------------------*/
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            
            var blog_content = CKEDITOR.instances['blog_content'] ? CKEDITOR.instances['blog_content'].getData() : '';
            var blog_content_ar = CKEDITOR.instances['blog_content_ar'] ? CKEDITOR.instances['blog_content_ar'].getData() : '';
            
            var formdata = new FormData(document.getElementById('packageForm'));
            formdata.append('blog_content', blog_content);
            formdata.append('blog_content_ar', blog_content_ar);
            
            $.ajax({
                enctype: 'multipart/form-data',
                url: "{{ route('blog.store') }}",
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#packageForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    toastr.options.timeOut = 5000;
                    toastr.success(data.success);
                },
                error: function (response) {
                    if (response.status === 422) {
                        var errors = response.responseJSON.errors;
                        $.each(errors, function (field_name, error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error('An error occurred. Please try again.');
                    }
                    $('#saveBtn').html('Save Changes');
                }
            });
        });


        /*------------------------------------------
        --------------------------------------------
        Delete Code
        --------------------------------------------
        --------------------------------------------*/
        
        $('body').on('click', '.deleteProduct', function () {

            var item_id = $(this).data("id");

                swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('blog.store') }}" + '/' + item_id,
                        success: function (data) {
                            table.draw();
                            toastr.options.timeOut = 5000;
                            toastr.success("Record has been deleted");
                        },
                        error: function (response) {
                            toastr.options.timeOut = 5000;
                            toastr.error(data);

                        }
                    });
                }
            });

        });
        

    });



</script>
<!-- push external js -->
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
@endpush
@endsection