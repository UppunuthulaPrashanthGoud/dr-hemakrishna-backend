@extends('layouts.main') @section('title', 'Contact Requests') @section('content')

<!-- push external head elements to head -->
@push('head')
<link
    rel="stylesheet"
    href="{{ asset('plugins/DataTables/datatables.min.css') }}"
/>
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}" />
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline">
                        <h5>Contact Requests</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"
                                ><i class="ik ik-home"></i
                            ></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Contact Requests</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <thead>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px !important">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mx-auto" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form
                    id="productForm"
                    name="productForm"
                    class="form-horizontal"
                    enctype="multipart/form-data"
                >
                    <input type="hidden" name="item_id" id="item_id" />
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label"
                            >Contact Name</label
                        >
                        <div class="col-sm-12">
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                placeholder="Enter name"
                                readonly
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label"
                            >Email</label
                        >
                        <div class="col-sm-12">
                            <input
                                type="text"
                                class="form-control"
                                id="email"
                                name="email"
                                readonly
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label"
                            >Phone number</label
                        >
                        <div class="col-sm-12">
                            <input
                                type="number"
                                class="form-control"
                                id="phone"
                                name="phone"
                                readonly                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label"
                            >Message</label
                        >
                        <div class="col-sm-12">
                            <textarea name="message" readonly id="message" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="container">
                        <div class="text-center">
                            <button
                                type="button"
                                class="btn btn-primary"
                                data-dismiss="modal"
                            >
                                close
                            </button>
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
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/

        var table = $(".data-table").DataTable({
            processing: true,
            serverSide: true,
            dom: '<"top"<"left-col"B><"center-col"l><"right-col"f>>rtip',
            ajax: "{{ route('contact.index') }}",
            columns: [
                { title:'No', data: "DT_RowIndex", name: "DT_RowIndex" },
                { title:'Name', data: "name", name: "name" },
                { title:'Email Address', data: "email", name: "email" },
                { title:'Phone Number', data: "phone", name: "phone" },
                { title:'Message', data: "message", name: "message" },
                {
                    title:'Action',
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ],
            buttons: ["pdf", "excel"],
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $("body").on("click", ".editProduct", function () {
            $("#productForm").trigger("reset");

            var item_id = $(this).data("id");
            $.get(
                "{{ route('contact.index') }}" + "/" + item_id + "/edit",
                function (data) {
                    $("#modelHeading").html("View Contact Request Details");
                    $("#saveBtn").val("edit-user");
                    $("#ajaxModel").modal("show");
                    $("#item_id").val(data.id);
                    $("#name").val(data.name);
                    $("#email").val(data.email);
                    $("#phone").val(data.phone);
                    $("#address").val(data.address);
                }
            );
        });


        /*------------------------------------------
        --------------------------------------------
        Delete Product Code
        --------------------------------------------
        --------------------------------------------*/
        $("body").on("click", ".deleteProduct", function () {
            var item_id = $(this).data("id");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('contact.store') }}" + "/" + item_id,
                success: function (data) {
                    table.draw();
                    toastr.options.timeOut = 5000;
                    toastr.error("Record has been deleted");
                },
                error: function (data) {
                    console.log("Error:", data);
                },
            });
        });
    });
</script>
<!-- push external js -->
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--server side users table script-->
<script src="{{ asset('js/custom.js') }}"></script>

@endpush @endsection
