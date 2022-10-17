<?php

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
        Route::resource('/project', 'App\Http\Controllers\ProjectController');
        Route::resource('/backlog', 'App\Http\Controllers\BacklogController');
        Route::resource('/sprint', 'App\Http\Controllers\SprintController');
        Route::resource('/task', 'App\Http\Controllers\TaskController');
        // Route::get('/user', [ UserController::class, "index" ])->name('user.data');
        // Route::get('/user/new', [ UserController::class, "create" ])->name('user.create');
        // Route::post('/user/new', [ UserController::class, "store" ])->name('user.store');
        // Route::get('/user/edit/{id}', [UserController::class, "edit"])->name('user.edit');
        // Route::patch('/user/edit/{id}', [UserController::class, "update"])->name('user.update');
        // Route::view('/user/new', "pages.user.user-new")->name('user.new');
        // Route::view('/user/edit/{userId}', "pages.user.user-edit")->name('user.edit');
        // Route::get('/user/new', function () {return view('pages.user.user-new');})->name('user.new');
    });
});

require __DIR__ . '/jetstream.php';
