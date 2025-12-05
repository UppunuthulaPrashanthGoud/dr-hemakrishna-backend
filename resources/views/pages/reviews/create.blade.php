@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Create New Reviews</h2>

        <form method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
        <input type="text" name="name" id="name" class="form-control" />
    </div>
</div>
<div class="form-group row">
    <label for="rating" class="col-sm-2 col-form-label">Rating</label>
    <div class="col-sm-10">
        <input type="text" name="rating" id="rating" class="form-control" />
    </div>
</div>
<div class="form-group row">
    <label for="content" class="col-sm-2 col-form-label">Content</label>
    <div class="col-sm-10">
        <x-ckeditor name="content" id="content" :value="null" />
    </div>
</div>
<div class="form-group row">
    <label for="image" class="col-sm-2 col-form-label">Image</label>
    <div class="col-sm-10">
        <x-image-input name="image" columns="col-md-12" value="" id="image" label="Image" />
    </div>
</div>

        <div class="form-group row">

            <div class="col-sm-10 offset-sm-2">
<button type="submit" class="btn btn-success">Submit</button>

            </div></div>
</form>
</div>
@endsection