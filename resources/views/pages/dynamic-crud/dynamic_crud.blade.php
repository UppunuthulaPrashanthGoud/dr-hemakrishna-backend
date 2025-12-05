@extends('layouts.main')
@section('title', 'Create Dynamic CRUD')

@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
@endpush

@section('content')
<div class="container my-4">
    <h2 class="mb-4">Create Dynamic CRUD</h2>
    <form action="{{ route('dynamic.crud.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-3 col-md-3">
                    <label for="table_name" class="form-label"><strong>Table Name</strong></label>
                    <input type="text" name="table_name" id="table_name" class="form-control" placeholder="Enter table name" required>
                </div>

                <hr>
                <div id="columns" class=" container">
                <h5>columns</h5>
                    <div class="column row g-3 align-items-end" data-index="0">
                        <div class="col-md-3">
                            <label for="columns[0][name]" class="form-label">Column Name</label>
                            <input type="text" name="columns[0][name]" class="form-control" placeholder="Enter column name" required>
                        </div>
                        <div class="col-md-3">
                            <label for="columns[0][type]" class="form-label">Column Type</label>
                            <select name="columns[0][type]" class="form-select" required>
                                <option value="string">String</option>
                                <option value="integer">Integer</option>
                                <option value="text">Text</option>
                                <option value="boolean">Boolean</option>
                                <option value="date">Date</option>
                                <option value="time">Time</option>
                                <option value="datetime">DateTime</option>
                                <option value="float">Float</option>
                                <option value="double">Double</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="columns[0][html_type]" class="form-label">Input Type</label>
                            <select name="columns[0][html_type]" class="form-select" required>
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="email">Email</option>
                                <option value="password">Password</option>
                                <option value="textarea">Textarea</option>
                                <option value="select">Select</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="radio">Radio</option>
                                <option value="file">File</option>
                                <option value="date">Date</option>
                                <option value="time">Time</option>
                                <option value="datetime-local">Datetime Local</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="columns[0][nullable]" class="form-label">Nullable</label>
                            <select name="columns[0][nullable]" class="form-select">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-center">
                            <button type="button" class="btn btn-danger remove-column" style="display: none;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="container">
                <div class="mt-4">
                    <button type="button" id="addColumn" class="btn btn-secondary">
                        <i class="bi bi-plus-circle"></i> Add Column
                    </button>
                </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Create</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
<script>
    let columnIndex = 1;

    document.getElementById('addColumn').addEventListener('click', function () {
        const columnsContainer = document.getElementById('columns');
        const newColumn = `
            <div class="column row g-3 align-items-end" data-index="${columnIndex}">
                <div class="col-md-3">
                    <label for="columns[${columnIndex}][name]" class="form-label">Column Name</label>
                    <input type="text" name="columns[${columnIndex}][name]" class="form-control" placeholder="Enter column name" required>
                </div>
                <div class="col-md-3">
                    <label for="columns[${columnIndex}][type]" class="form-label">Column Type</label>
                    <select name="columns[${columnIndex}][type]" class="form-select" required>
                        <option value="string">String</option>
                        <option value="integer">Integer</option>
                        <option value="text">Text</option>
                        <option value="boolean">Boolean</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                        <option value="datetime">DateTime</option>
                        <option value="float">Float</option>
                        <option value="double">Double</option>
                        <option value="file">File</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="columns[${columnIndex}][html_type]" class="form-label">Input Type</label>
                    <select name="columns[${columnIndex}][html_type]" class="form-select" required>
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="email">Email</option>
                        <option value="password">Password</option>
                        <option value="textarea">Textarea</option>
                        <option value="select">Select</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="radio">Radio</option>
                        <option value="file">File</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                        <option value="datetime-local">Datetime Local</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="columns[${columnIndex}][nullable]" class="form-label">Nullable</label>
                    <select name="columns[${columnIndex}][nullable]" class="form-select">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-danger remove-column">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        columnsContainer.insertAdjacentHTML('beforeend', newColumn);
        columnIndex++;

        // Show remove button for newly added column
        const removeColumnButtons = document.querySelectorAll('.remove-column');
        removeColumnButtons.forEach(button => {
            button.style.display = 'inline-block';
            button.addEventListener('click', function () {
                button.closest('.column').remove();
            });
        });
    });
</script>
@endpush
