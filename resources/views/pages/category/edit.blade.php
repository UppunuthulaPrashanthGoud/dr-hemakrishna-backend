@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Category</h2>

        <form method="POST" action="{{ route('category.update', $item->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
        <input type="text" name="name" id="name" class="form-control" value="{{ $item->name }}" />
    </div>
</div>


            <div class="form-group row">
<div class="col-sm-10 offset-sm-2">
<button type="submit" class="btn btn-success">Submit</button>

            </div></div>
</form>
</div>
@endsection