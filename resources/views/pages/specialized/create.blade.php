@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Create New Specialized</h2>

        <form method="POST" action="{{ route('specialized.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
    <label for="image" class="col-sm-2 col-form-label">Image</label>
    <div class="col-sm-10">
        <x-image-input name="image" columns="col-md-12" value="" id="image" label="Image" />
    </div>
</div>
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label">Title</label>
    <div class="col-sm-10">
        <input type="text" name="title" class="form-control" value="">
    </div>
</div>
<div class="form-group row">
    <label for="content" class="col-sm-2 col-form-label">Content</label>
    <div class="col-sm-10">
        <x-ckeditor name="content" id="content" :value="null" />
    </div>
</div>

        <div class="form-group row">

            <div class="col-sm-10 offset-sm-2">
<button type="submit" class="btn btn-success">Submit</button>

            </div></div>
</form>
</div>
@endsection