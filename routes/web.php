<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SprintController;
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
        Route::resource('/task/board', 'App\Http\Controllers\BoardController');

        //Update User Password and Proposal Download
        Route::get('/project/{id}/download-proposal', 'App\Http\Controllers\ProjectController@downloadProposal')->name('project.proposal');
        Route::get('/client-user/{id}/update-password', 'App\Http\Controllers\ClientUserController@changePassword')->name('change.password');
        Route::put('/client-user/{id}/update-pass', 'App\Http\Controllers\ClientUserController@editPassword')->name('user.password');

        //Project Task
        Route::get('/project/{id}/tasks', 'App\Http\Controllers\TaskController@taskList')->name('project.task');
        Route::get('/project/{id}/table-view', 'App\Http\Controllers\TaskController@tableView')->name('project.task.table');
        Route::get('/project/{id}/finished-tasks', 'App\Http\Controllers\TaskController@taskFinished')->name('project.task.finished');
        Route::get('/project/{id}/create-task', 'App\Http\Controllers\TaskController@createTask')->name('project.task.create');
        Route::get('/project/{id}/tasks/{task}/edit', 'App\Http\Controllers\TaskController@editTask')->name('project.task.edit');
        Route::post('/project/store-task', 'App\Http\Controllers\TaskController@storeTask')->name('project.task.store');
        Route::put('/project/{id}/tasks/{task}/update-task', 'App\Http\Controllers\TaskController@updateTask')->name('project.task.update');
        Route::put('/project/{task}/move-task', 'App\Http\Controllers\TaskController@moveTask')->name('project.task.move');
        Route::put('/project/{task}/status', 'App\Http\Controllers\TaskController@taskStatus')->name('project.task.status');
        Route::delete('/project/{task}/destroy-task', 'App\Http\Controllers\TaskController@destroyTask')->name('project.task.destroy');

        //Project Board
        Route::get('/project/{id}/create-board', 'App\Http\Controllers\BoardController@createBoard')->name('project.board.create');
        Route::post('/project/store-board', 'App\Http\Controllers\BoardController@storeBoard')->name('project.board.store');
        Route::get('/project/{id}/tasks/edit-board/{board}', 'App\Http\Controllers\BoardController@editBoard')->name('project.board.edit');
        Route::put('/project/{id}/tasks/update-board/{board}', 'App\Http\Controllers\BoardController@updateBoard')->name('project.board.update');
        Route::delete('/project/{id}/destroy-board', 'App\Http\Controllers\BoardController@destroyBoard')->name('project.board.destroy');
    
        //Project Sprint
        Route::get('project/{id}/create-sprint', 'App\Http\Controllers\SprintController@createProjectSprint')->name('project.sprint.create');
        Route::post('/project/store-sprint', 'App\Http\Controllers\SprintController@storeProjectSprint')->name('project.sprint.store');
        Route::get('/project/{id}/sprint/{sprint}/edit', 'App\Http\Controllers\SprintController@editProjectSprint')->name('project.sprint.edit');
        Route::put('/project/{id}/sprint/{sprint}/update-sprint', 'App\Http\Controllers\SprintController@updateProjectSprint')->name('project.sprint.update');
        Route::put('/project/{id}/sprint/{sprint}/sprint-status', 'App\Http\Controllers\SprintController@sprintStatus')->name('project.sprint.status');

        //Project Backlog
        Route::get('project/{id}/create-backlog', 'App\Http\Controllers\BacklogController@createProjectBacklog')->name('project.backlog.create');
        Route::post('/project/store-backlog', 'App\Http\Controllers\BacklogController@storeProjectBacklog')->name('project.backlog.store');
        Route::get('/project/{id}/backlog/{backlog}/edit', 'App\Http\Controllers\BacklogController@editProjectBacklog')->name('project.backlog.edit');
        Route::put('/project/{id}/backlog/{backlog}/update-backlog', 'App\Http\Controllers\BacklogController@updateProjectBacklog')->name('project.backlog.update');
    
        //Project Report
        Route::get('/report', 'App\Http\Controllers\ReportController@index')->name('report.index');
        Route::get('/project/{id}/reports', 'App\Http\Controllers\ReportController@show')->name('project.report');

        //Project Timesheet
        Route::get('/project/{id}/tasks/{tasks}/record', 'App\Http\Controllers\TimesheetController@createTimesheet')->name('project.timesheet.create');
        Route::post('/project/store-timesheet', 'App\Http\Controllers\TimesheetController@storeTimesheet')->name('project.timesheet.store');
    });

    Route::group(['middleware' => 'role:product-owner'], function() {
        Route::resource('/project', 'App\Http\Controllers\ProjectController');
        Route::resource('/backlog', 'App\Http\Controllers\BacklogController');
        Route::resource('/sprint', 'App\Http\Controllers\SprintController');
        Route::resource('/task', 'App\Http\Controllers\TaskController');

        Route::get('/project/{id}/download-proposal', 'App\Http\Controllers\ProjectController@downloadProposal')->name('project.proposal');
        Route::get('/project/{id}/status', 'App\Http\Controllers\ProjectController@approve')->name('project.status');
        Route::put('/project/{id}/approval', 'App\Http\Controllers\ProjectController@approveProject')->name('project.approval');

        Route::get('/project/{id}/tasks', 'App\Http\Controllers\TaskController@taskList')->name('project.task');
        Route::get('/project/{id}/table-view', 'App\Http\Controllers\TaskController@tableView')->name('project.task.table');
        Route::get('/project/{id}/finished-tasks', 'App\Http\Controllers\TaskController@taskFinished')->name('project.task.finished');
    });

    Route::group(['middleware' => 'role:team-member'], function() {
        Route::resource('/project', 'App\Http\Controllers\ProjectController');
        Route::resource('/backlog', 'App\Http\Controllers\BacklogController');
        Route::resource('/sprint', 'App\Http\Controllers\SprintController');
        Route::resource('/task', 'App\Http\Controllers\TaskController');

        Route::get('/project/{id}/download-proposal', 'App\Http\Controllers\ProjectController@downloadProposal')->name('project.proposal');
        Route::get('/project/{id}/tasks', 'App\Http\Controllers\TaskController@taskList')->name('project.task');
        Route::get('/project/{id}/table-view', 'App\Http\Controllers\TaskController@tableView')->name('project.task.table');
        Route::get('/project/{id}/finished-tasks', 'App\Http\Controllers\TaskController@taskFinished')->name('project.task.finished');
    });
});

require __DIR__ . '/jetstream.php';
