@extends('layouts.main')
@section('title', 'Create Page Dynamic Item')

@push('head')
@endpush

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Create Dynamic Item for "{{ $page->page_name }}"</h5>
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
                        <li class="breadcrumb-item">
                            <a href="{{ route('pages.dynamic-items.index', $page->id) }}">Dynamic Items</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Create
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pages.dynamic-items.store', $page->id) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="content">Content</label>
                            <x-ckeditor id="content" name="content" :value="old('content')" />
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('pages.dynamic-items.index', $page->id) }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection