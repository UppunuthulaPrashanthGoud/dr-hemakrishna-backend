@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
    $segment3 = request()->segment(3);
    $settings = DB::table('general_settings')->first();
@endphp
<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('admin.dashboard')}}">
            <div class="logo-img">
            <img height="45" src="{{ asset($settings->header_logo) }}" onerror="this.src='/img/logo.png';" class="header-brand-img" title="Prashanth">
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment2 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('admin.dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{
                            __('Dashboard')}}</span></a>
                </div>
                <div class="nav-lavel">{{ __('Menu Items')}} </div>

                <div
                    class="nav-item {{ ($segment2 == 'users' || $segment2 == 'roles'||$segment2 == 'permission' ||$segment2 == 'user') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('admin/users')}}"
                            class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                        <a href="{{url('admin/user/create')}}"
                            class="menu-item {{ ($segment2 == 'user' && $segment3 == 'create') ? 'active' : '' }}">{{
                            __('Add User')}}</a>
                        @endcan
                        <!-- only those have manage_role permission will get access -->
                        @can('manage_roles')
                        <a href="{{url('admin/roles')}}"
                            class="menu-item {{ ($segment2 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                        @can('manage_permission')
                        <a href="{{url('admin/permission')}}"
                            class="menu-item {{ ($segment2 == 'permission') ? 'active' : '' }}">{{
                            __('Permission')}}</a>
                        @endcan
                    </div>
                </div>

                <!-- home page -->
                <div class="nav-item {{ ($segment2 == 'banners') ? 'active' : '' }}">
                    <a href="{{url('admin/banners')}}"><i class="ik ik-image"></i><span>Banners</span> </a>
                </div>

                <div class="nav-item {{ ($segment2 == 'highlights') ? 'active' : '' }}">
                    <a href="{{url('admin/highlights')}}"><i class="ik ik-image"></i><span>Highlights</span> </a>
                </div>

                <div class="nav-item {{ ($segment2 == 'firstgallery') ? 'active' : '' }}">
                    <a href="{{url('admin/firstgallery')}}"><i class="ik ik-image"></i><span>First Gallery</span> </a>
                </div>
                
                <div class="nav-item {{ ($segment2 == 'aboutitems') ? 'active' : '' }}">
                    <a href="{{url('admin/aboutitems')}}"><i class="ik ik-image"></i><span>About Items</span> </a>
                </div>

                <div class="nav-item {{ ($segment2 == 'specialized') ? 'active' : '' }}">
                    <a href="{{url('admin/specialized')}}"><i class="ik ik-image"></i><span>Specialized section</span> </a>
                </div>
                
                <div class="nav-item {{ ($segment2 == 'depratments') ? 'active' : '' }}">
                    <a href="{{url('admin/depratments')}}"><i class="ik ik-image"></i><span>Depratments</span> </a>
                </div>

                <div class="nav-item {{ ($segment2 == 'imagegallery') ? 'active' : '' }}">
                    <a href="{{url('admin/imagegallery')}}"><i class="ik ik-image"></i><span>Image Gallery</span> </a>
                </div>
                <div class="nav-item {{ ($segment2 == 'category') ? 'active' : '' }}">
                    <a href="{{url('admin/category')}}"><i class="ik ik-image"></i><span>Dynamic page Category</span> </a>
                </div>

                <div class="nav-item {{ ($segment2 == 'pages') ? 'active' : '' }}">
                    <a href="{{url('admin/pages')}}"><i class="ik ik-book"></i><span>Dynamic Pages</span> </a>
                </div>
                <!-- reviews -->
                <div class="nav-item {{ ($segment2 == 'reviews') ? 'active' : '' }}">
                    <a href="{{url('admin/reviews')}}"><i class="ik ik-star"></i><span>Reviews</span> </a>
                </div>

<!-- 
                <div class="nav-item {{ ($segment2 == 'blog') ? 'active' : '' }}">
                    <a href="{{url('admin/blog')}}"><i class="ik ik-rss"></i><span>Blogs</span> </a>
                </div> -->
                <!-- <div class="nav-item {{ ($segment2 == 'seo') ? 'active' : '' }}">
                    <a href="{{url('admin/seo')}}"><i class="ik ik-code"></i><span>SEO Sections</span> </a>
                </div> -->

                <div class="nav-item {{ ($segment2 == 'contact') ? 'active' : '' }}">
                    <a href="{{url('admin/contact')}}"><i class="ik ik-phone"></i><span>Contact</span> </a>
                </div>
                <!-- <div class="nav-item {{ ($segment2 == 'create-dynamic-crud') ? 'active' : '' }}">
                    <a href="{{url('admin/create-dynamic-crud')}}"><i class="ik ik-book"></i><span>Create Crud</span> </a>
                </div> -->

                

                <div class="nav-item {{ ($segment2 == 'general') ? 'active' : '' }}">
                    <a href="{{url('admin/general')}}"><i class="ik ik-settings"></i><span>General Settings</span> </a>
                </div>

        </div>
    </div>
</div>