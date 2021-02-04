<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CentersController;
use App\Http\Controllers\RoomController;
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
    Route::post('login',[UserController::class,'verify_login_post'])->name('user_login_post');
    Route::get('register',[UserController::class,'new_user'])->name('new_user_registration');
    Route::post('submit_registration',[UserController::class,'submit_registration'])->name('submit_registration');
    Route::post('user_verification_registration',[UserController::class,'submit_user_verification'])->name('submit_user_verification');
    Route::post('user_webcam_upload',[UserController::class,'store_webcam_upload'])->name('store_webcam_upload');
});

/**
 * Admins
 */
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login',[UserController::class,'ad_login'])->name('admin_login_index');

    /**
     * Users
     */
    Route::prefix('users')->name('admin_user.')->group(function () {
        Route::get("login",[UserController::class,'ad_login'])->name('admin_login');
    });
    Route::get('get_user_list',[UserController::class,'get_user_list'])->name('get_user_list');

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
});

