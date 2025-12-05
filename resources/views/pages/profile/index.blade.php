@extends('layouts.main') 
@section('title', 'Profile')
@section('content')


    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Admin profile')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Pages')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Settings')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class=" text-center mt-4"><h6>{{ __('Update Settings')}}</h6></div>
                    <div class="card-body">
                        <form class="forms-sample" method="post" action="{{url('admin/update-profile')}}">
                                @csrf
                            <div class="form-group row">
                                <label for="username" class="col-sm-4 col-form-label">{{ __('Username')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{$user->name}}" class="form-control" id="username" name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">{{ __('Email')}}</label>
                                <div class="col-sm-8">
                                    <input type="email" value="{{$user->email}}" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="oldPassword" class="col-sm-4 col-form-label">{{ __('Old Password')}}</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Old password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="newPassword" class="col-sm-4 col-form-label">{{ __('New Password')}}</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mr-2">{{ __('update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


    </div>
@endsection