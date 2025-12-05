<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title', '') | Prashanth CMS-Admin</title>
    <!-- initiate head with meta tags, css and script -->
    @include('layouts.include.head')
</head>
<body id="app">
    <div class="wrapper">
        <!-- initiate header (conditionally loaded) -->
        @hasSection('no-header')
            @yield('no-header')
        @else
            @include('layouts.include.header')
        @endif

        <div class="page-wrap">
            <!-- initiate sidebar -->
            @include('layouts.include.sidebar')

            <div class="main-content">
                <!-- yield contents here -->
                @yield('content')
            </div>

            <!-- initiate footer section (conditionally loaded) -->
            @hasSection('no-footer')
                @yield('no-footer')
            @else
                @include('layouts.include.footer')
            @endif
        </div>
    </div>

    <!-- initiate scripts -->
    @include('layouts.include.script')
</body>
</html>
