<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Users;

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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
    
    Route::group(['middleware' => 'role:project-manager'], function() {
        Route::resource('/user', 'App\Http\Controllers\UserController');
        Route::resource('/client', 'App\Http\Controllers\ClientController');
        Route::resource('/client-user', 'App\Http\Controllers\ClientUserController');
        Route::resource('/project', 'App\Http\Controllers\ProjectController');
        Route::resource('/backlog', 'App\Http\Controllers\BacklogController');
        Route::resource('/sprint', 'App\Http\Controllers\SprintController');
        Route::resource('/task', 'App\Http\Controllers\TaskController');

        Route::get('/project/{id}/download-proposal', 'App\Http\Controllers\ProjectController@downloadProposal')->name('project.proposal');
        Route::get('/client-user/{id}/update-password', 'App\Http\Controllers\ClientUserController@changePassword')->name('change.password');
        Route::put('/client-user/{id}/update-pass', 'App\Http\Controllers\ClientUserController@editPassword')->name('user.password');
    });

    Route::group(['middleware' => 'role:product-owner'], function() {
        Route::resource('/project', 'App\Http\Controllers\ProjectController');
        Route::resource('/backlog', 'App\Http\Controllers\BacklogController');
        Route::resource('/sprint', 'App\Http\Controllers\SprintController');
        Route::resource('/task', 'App\Http\Controllers\TaskController');

        Route::get('/project/{id}/download-proposal', 'App\Http\Controllers\ProjectController@downloadProposal')->name('project.proposal');
        Route::get('/project/{id}/status', 'App\Http\Controllers\ProjectController@approve')->name('project.status');
        Route::put('/project/{id}/approval', 'App\Http\Controllers\ProjectController@approveProject')->name('project.approval');
    });
});

require __DIR__ . '/jetstream.php';
