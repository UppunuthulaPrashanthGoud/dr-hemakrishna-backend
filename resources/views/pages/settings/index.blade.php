@extends('layouts.main') @section('title', 'General Settings') @section('content')

<!-- push external head elements to head -->
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}" />
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}" />
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline">
                        <h5>General Settings</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">General Settings</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div>
        <form method="post" action="{{url('admin/general/update')}}"  class="row" enctype="multipart/form-data">
            @csrf
            <!-- Header Section -->
            
            <x-image-input name="header_logo" columns="col-md-3" value="{{ $general->header_logo }}" label="Header Logo" />
            <x-image-input name="footer_logo" columns="col-md-3" value="{{ $general->footer_logo }}" label="Footer Logo" />
            <x-image-input name="favicon" columns="col-md-3" value="{{ $general->favicon }}" label="Favicon" />
            
            <div class="form-group col-md-3">
                <label for="header_phone">Header Phone</label>
                <input type="number" class="form-control" id="header_phone" name="header_phone" value="{{$general->header_phone}}"
                    placeholder="Header Phone" />
            </div>
            <div class="form-group col-md-3">
                <label for="header_email">Header Email</label>
                <input type="email" class="form-control" id="header_email" name="header_email" value="{{$general->header_email}}"
                    placeholder="Header Email" />
            </div>

            <!-- Social Media Section -->
            <div class="form-group col-md-3">
                <label for="fb_link">Facebook Link</label>
                <input type="url" class="form-control" id="fb_link" name="fb_link" placeholder="Facebook Link" value="{{$general->fb_link}}" />
            </div>
            <div class="form-group col-md-3">
                <label for="insta_link">Instagram Link</label>
                <input type="url" class="form-control" id="insta_link" name="insta_link" placeholder="Instagram Link" value="{{$general->insta_link}}" />
            </div>
            <div class="form-group col-md-3">
                <label for="twitter_link">Twitter Link</label>
                <input type="url" class="form-control" id="twitter_link" name="twitter_link" value="{{$general->twitter_link}}"
                    placeholder="Twitter Link" />
            </div>
            <div class="form-group col-md-3">
                <label for="pintrest_link">Pinterest Link</label>
                <input type="url" class="form-control" id="pintrest_link" name="pintrest_link" value="{{$general->pintrest_link}}"
                    placeholder="Pinterest Link" />
            </div>
            <div class="form-group col-md-3">
                <label for="youtube_link">YouTube Link</label>
                <input type="url" class="form-control" id="youtube_link" name="youtube_link" value="{{$general->youtube_link}}"
                    placeholder="YouTube Link" />
            </div>
            <div class="form-group col-md-3">
                <label for="linkdin_link">LinkedIn Link</label>
                <input type="url" class="form-control" id="linkdin_link" name="linkdin_link" value="{{$general->linkdin_link}}"
                    placeholder="LinkedIn Link" />
            </div>

            <!-- Contact Section -->
            <div class="form-group col-md-3">
                <label for="whatsapp_no">WhatsApp Number</label>
                <input type="number" class="form-control" id="whatsapp_no" name="whatsapp_no" value="{{$general->whatsapp_no}}"
                    placeholder="WhatsApp Number" />
            </div>

            <!-- Footer Section -->
            
            <div class="form-group col-md-3">
                <label for="footer_email">Footer Email</label>
                <input type="email" class="form-control" id="footer_email" name="footer_email" value="{{$general->footer_email}}"
                    placeholder="Footer Email" />
            </div>
            <div class="form-group col-md-3">
                <label for="footer_phone">Footer Phone</label>
                <input type="number" class="form-control" id="footer_phone" name="footer_phone" value="{{$general->footer_phone}}"
                    placeholder="Footer Phone" />
            </div>
            <div class="form-group col-md-3">
                <label for="footer_copyright">Footer Copyright</label>
                <input type="text" class="form-control" id="footer_copyright" name="footer_copyright" value="{{$general->footer_copyright}}"
                    placeholder="Footer Copyright" />
            </div>

            <!-- Website Section -->
            <div class="form-group col-md-3">
                <label for="website_name">Website Name</label>
                <input type="text" class="form-control" id="website_name" name="website_name" value="{{$general->website_name}}"
                    placeholder="Website Name" />
            </div>
            

            <!-- Submit Button -->
            <div class="text-center col-12 mt-2">
                <button type="submit" class="btn btn-primary btn-lg">Update Settings</button>
            </div>
        </form>

    </div>
</div>


@push('script')
@endpush

@endsection