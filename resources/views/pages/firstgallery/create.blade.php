@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Create New Firstgallery</h2>

        <form method="POST" action="{{ route('firstgallery.store') }}" enctype="multipart/form-data">
        @csrf
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