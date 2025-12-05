<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\UploadMultipleImageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\DynamicCrudController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('admin.login');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('admin.login');
    // Authentication Routes
    Route::post('login', [LoginController::class, 'login']);
    Route::get('/logout', [LoginController::class, 'logout']);
    

    Route::get('/clear-cache', [HomeController::class, 'clearCache']);

    // Password Reset Routes
    Route::get('password/forget', function () {
        return view('auth.forgot-password');
    })->name('password.forget');
    
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::middleware(['auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('admin.profile');
        Route::post('/update-profile', [DashboardController::class, 'update_profile'])->name('admin.update-profile');
       
        // User Management Routes
        Route::middleware(['can:manage_user'])->group(function () {
            Route::get('/users', [UserController::class, 'index']);
            Route::get('/user/get-list', [UserController::class, 'getUserList']);
            Route::get('/user/create', [UserController::class, 'create']);
            Route::post('/user/create', [UserController::class, 'store'])->name('create-user');
            Route::get('/user/{id}', [UserController::class, 'edit']);
            Route::post('/user/update', [UserController::class, 'update']);
            Route::get('/user/delete/{id}', [UserController::class, 'delete']);
        });

        // Role Management Routes
        Route::middleware(['can:manage_role|manage_user'])->group(function () {
            Route::get('/roles', [RolesController::class, 'index']);
            Route::get('/role/get-list', [RolesController::class, 'getRoleList']);
            Route::post('/role/create', [RolesController::class, 'create']);
            Route::get('/role/edit/{id}', [RolesController::class, 'edit']);
            Route::post('/role/update', [RolesController::class, 'update']);
            Route::get('/role/delete/{id}', [RolesController::class, 'delete']);
        });

        // Permission Management Routes
        Route::middleware(['can:manage_permission|manage_user'])->group(function () {
            Route::get('/permission', [PermissionController::class, 'index']);
            Route::get('/permission/get-list', [PermissionController::class, 'getPermissionList']);
            Route::post('/permission/create', [PermissionController::class, 'create']);
            Route::get('/permission/update', [PermissionController::class, 'update']);
            Route::get('/permission/delete/{id}', [PermissionController::class, 'delete']);
        });

        // Banners and Contact Management Routes
        Route::get('/banner-status/{status}/{id}', [BannersController::class, 'bannerStatus']);
        Route::resource('/banners', BannersController::class);
        Route::resource('/contact', ContactController::class);
        Route::get('/general', [GeneralController::class, 'index']);
        Route::post('/general/update',[ GeneralController::class, 'update']);

        // home route
        Route::resource('highlights', Admin\HighlightsController::class);
        Route::resource('firstgallery', Admin\FirstgalleryController::class);
        Route::resource('aboutitems', Admin\AboutitemsController::class);
        Route::resource('specialized', Admin\SpecializedController::class);
        Route::resource('depratments', Admin\DepratmentsController::class);
        Route::resource('imagegallery', Admin\ImagegalleryController::class);
        Route::resource('category', Admin\CategoryController::class);
        Route::resource('reviews', Admin\ReviewsController::class);

        // Change any record status
        Route::get('change-status/{tableName}/{id}', [GeneralController::class, 'changeStatus'])->name('change-status');


        // Get Permissions
        Route::get('get-role-permissions-badge', [PermissionController::class, 'getPermissionBadgeByRole']);

        // Dynamic pages
        Route::resource('pages', PageController::class);
        // Blog
        Route::resource('/blog', BlogController::class);
        // SEO
        Route::resource('gallery', Admin\GalleryController::class);
        Route::resource('/seo', SeoController::class);
        Route::get('/create-dynamic-crud', [DynamicCrudController::class, 'create'])->name('dynamic.crud.create');
        Route::post('/dynamic-crud/store', [DynamicCrudController::class, 'store'])->name('dynamic.crud.store');
    });


});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
















