@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Highlights</h2>

        <form method="POST" action="{{ route('highlights.update', $item->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label">Title</label>
    <div class="col-sm-10">
        <input type="text" name="title" id="title" class="form-control" value="{{ $item->title }}" />
    </div>
</div>
<div class="form-group row">
    <label for="countnumber" class="col-sm-2 col-form-label">Countnumber</label>
    <div class="col-sm-10">
        <input type="text" name="countnumber" id="countnumber" class="form-control" value="{{ $item->countnumber }}" />
    </div>
</div>
<div class="form-group row">
    <label for="image" class="col-sm-2 col-form-label">Image</label>
    <div class="col-sm-10">
        <x-image-input name="image" columns="col-md-12" value="{{ $item->image }}" id="image" label="Image" />
    </div>
</div>
<div class="form-group row">
    <label for="content" class="col-sm-2 col-form-label">Content</label>
    <div class="col-sm-10">
        <x-ckeditor name="content" id="content" :value="$item->content" />
    </div>
</div>


            <div class="form-group row">
<div class="col-sm-10 offset-sm-2">
<button type="submit" class="btn btn-success">Submit</button>

            </div></div>
</form>
</div>
@endsection