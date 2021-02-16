<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CentersController;
use App\Http\Controllers\RoomController;
<<<<<<< HEAD
use App\Http\Controllers\RoomDetailController;
=======
>>>>>>> 2ecfb6a5988454b180d0df9ea286cddee35b0d78
use App\Http\Controllers\SewasController;
use App\Http\Controllers\BookingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('login',[UserController::class,'ad_login'])->name('user_login');

});

<<<<<<< HEAD
/**
 * Admins
 */
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login',[UserController::class,'ad_login'])->name('admin_login_index');

    Route::get('path in url',[RoomDetailController::class,'method to access when in this url'])->name('name of the route to call from view file');

    /**
     * Users
     */
    Route::prefix('users')->name('admin_user.')->group(function () {
        Route::get("login",[UserController::class,'ad_login'])->name('admin_login');
    });
    Route::get('get_user_list',[UserController::class,'get_user_list'])->name('get_user_list'); // get list of users for select 2 data.

    Route::name('users.')->group( function () {
        Route::get('register',[UserController::class,'new_user'])->name('new_user_registration');
        Route::get('user-list',[UserController::class,'index'])->name('user-list');
        Route::post('login',[UserController::class,'verify_login_post'])->name('user_login_post');
        Route::post('submit_registration',[UserController::class,'submit_registration'])->name('submit_registration');
        Route::post('user_verification_registration',[UserController::class,'submit_user_verification'])->name('submit_user_verification');
        Route::post('user_webcam_upload',[UserController::class,'store_webcam_upload'])->name('store_webcam_upload');
        Route::post('user_references',[UserController::class,'save_sewa_reference'])->name('user-reference');
    });

    /**
     * Dashboard
     */

    Route::get('dashboard',[DashboardController::class,'ad_dashboard'])->name('admin_dashboard');


    
    /**
     * Centers
     */
     Route::prefix('centers')->name('centers.')->group(function () {

        Route::get('center_list',[CentersController::class,'index'])->name('center_list');
        Route::get('new_center',[CentersController::class,'new_center_form'])->name('new_center_form');
        Route::post('submit_center_record',[CentersController::class,'create_center'])->name('submit_center_record');
     });

     Route::prefix('services')->name('services.')->group(function () {
         /**
          * Sewas
          */
          Route::prefix('sewas')->name('sewas.')->group(function(){
            Route::get('index',[SewasController::class,'index'])->name('index');
            Route::get('form',[SewasController::class,'sewa_form'])->name('form');
            Route::get('delete-form',[SewasController::class,'destroy_form'])->name('delete-form');
            Route::post('delete',[SewasController::class,'destroy'])->name('delete');
            Route::post('submit-new-form',[SewasController::class,'store'])->name('submit-new-form');
            Route::post('update-sewa-service',[SewasController::class,'update_sewa_service'])->name('update-sewa-service');
          });
     });
});

=======
>>>>>>> 2ecfb6a5988454b180d0df9ea286cddee35b0d78
