<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="description" content="uppunuthula prashanth">
<meta name="keywords" content="uppunuthula prashanth">
<meta name="viewport" content="width=device-width, initial-scale=1">
@php
    $settings = DB::table('general_settings')->first();
@endphp

<link rel="icon" href="{{ asset($settings->favicon)}}" />

<!-- font awesome library -->
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

<script src="{{ asset('js/app.js') }}"></script>

<!-- Prashanth admin  asstes -->
<link rel="stylesheet" href="{{ asset('dist/css/bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/theme.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/icon-kit/dist/css/iconkit.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/ionicons/dist/css/ionicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/toaster/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
<!-- Stack array for including inline css or head elements -->
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
@stack('head')


