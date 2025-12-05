<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/unauthenticated', function () {
    return response()->json(['message' => 'Unauthenticated.'], 403);
});
Route::post('login', [AuthController::class,'login']);


// Frontend api's
Route::group(['prefix' => 'client'], function () {
	Route::get('get-banners-list', [HomepageController::class, 'getBanners']);
	Route::post('contact-submit', [ContactController::class, 'submit_request']);

	Route::get('get-highlights-list', [HomepageController::class, 'getHighlights']);
	Route::get('get-firstgallery-list', [HomepageController::class, 'getFirstgallery']);
	Route::get('get-aboutitems-list', [HomepageController::class, 'getAboutitems']);
	Route::get('get-specialized-list', [HomepageController::class, 'getSpecialized']);
	Route::get('get-depratments-list', [HomepageController::class, 'getDepratments']);
	Route::get('get-imagegallery-list', [HomepageController::class, 'getImagegallery']);
	// reviews
	Route::get('get-reviews-list', [HomepageController::class, 'getReviews']);

	
Route::post('appointment', [AppointmentController::class, 'storeAppointment']);
Route::post('contact', [AppointmentController::class, 'storeContact']);

	// general settings
	Route::get('general-settings', [HomepageController::class, 'getGeneralSettings']);
	// get dynamic page category
	Route::get('get-dynamic-page-category', [HomepageController::class, 'getDynamicPageCategory']);
	// get dynamic page
	Route::get('get-dynamic-page/{slug}', [HomepageController::class, 'getDynamicPage']);
});






Route::group(['middleware' => 'auth:api'], function(){
	Route::get('logout', [AuthController::class,'logout']);
	Route::get('profile', [AuthController::class,'profile']);
	Route::post('change-password', [AuthController::class,'changePassword']);
	Route::post('update-profile', [AuthController::class,'updateProfile']);
	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
		Route::get('/users', [UserController::class,'list']);
		Route::post('/user/create', [UserController::class,'store']);
		Route::get('/user/{id}', [UserController::class,'profile']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
		Route::post('/user/change-role/{id}', [UserController::class,'changeRole']);
	});
	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'list']);
		Route::post('/role/create', [RolesController::class,'store']);
		Route::get('/role/{id}', [RolesController::class,'show']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
		Route::post('/role/change-permission/{id}', [RolesController::class,'changePermissions']);
	});
	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permissions', [PermissionController::class,'list']);
		Route::post('/permission/create', [PermissionController::class,'store']);
		Route::get('/permission/{id}', [PermissionController::class,'show']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	
});

