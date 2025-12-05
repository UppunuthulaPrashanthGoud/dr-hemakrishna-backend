@extends('layouts.main')
@section('title', 'Pages')

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
                        <h5>Pages List</h5>
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
                            <a href="#">Pages List</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary mb-3" href="javascript:void(0)" id="createNewPage"> Create new page &nbsp; <i class="fa fa-plus"></i></a>
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
                <form id="pageForm" name="pageForm" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" name="item_id" id="item_id">
                    <div class="form-group">
                        <label for="category_id" class="col-sm-6 control-label">Category</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($category as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="page_name" class="col-sm-6 control-label">Page Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="page_name" name="page_name" placeholder="Enter Page Name" required="true">
                        </div>
                    </div>

                        <div class="form-group ">
                            <label  class="col-sm-6 control-label">Content (EN)</label>
                            <div class="col-sm-12">
                            <x-ckeditor id="content" name="content" :value="null" />
                            </div>
                        </div>


                        <div class="form-group ">
                            <label class="col-sm-6 control-label">Content (AR)</label>
                            <div class="col-sm-12">
                            <x-ckeditor id="content_ar" name="content_ar" :value="null" />
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
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3" required="true"></textarea>
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

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
            ajax: "{{ route('pages.index') }}",
            columns: [
                {data: 'id', name: 'id', title: 'ID'},
                {data: 'page_name', name: 'page_name', title: 'Page Name'},
                {data: 'category.name', name: 'category.name', title: 'Category'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    title: 'Action'
                },
            ]
        });

        $('#createNewPage').click(function () {
            $('#saveBtn').val("create-page");
            $('#item_id').val('');
            $('#pageForm').trigger("reset");
            $('#modelHeading').html("Create New Page");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editProduct', function () {
            var item_id = $(this).data('id');
            $.get("{{ route('pages.index') }}" + '/' + item_id + '/edit', function (data) {
                $('#modelHeading').html("Edit Page");
                $('#saveBtn').val("edit-page");
                $('#ajaxModel').modal('show');
                $('#item_id').val(data.id);
                $('#page_name').val(data.page_name);
                if (CKEDITOR.instances['content']) {
                    CKEDITOR.instances['content'].setData(data.content ?? '');
                }
                if (CKEDITOR.instances['content_ar']) {
                    CKEDITOR.instances['content_ar'].setData(data.content_ar ?? '');
                }

                $('#category_id').val(data.category_id);
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
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#pageForm').serialize(),
                url: "{{ route('pages.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#pageForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    showNotification('Success', data.success, 'success');
                    $('#saveBtn').html('Save');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });

        $('body').on('click', '.deleteProduct', function () {

            var item_id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if (result) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('pages.store') }}"+'/'+item_id,
                    success: function (data) {
                        table.draw();
                        showNotification('Success', data.success, 'success');
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });

    });
</script>
<!-- push external js -->
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
@endpush