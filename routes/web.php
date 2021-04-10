<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
	return view('welcome');
});

Route::get('/dashboard', function () {

	$currentAccountStatus = Auth::user()->user_status;
	if($currentAccountStatus == 0){
		return view('user_status_0');
	}
	else{
		return view('default_dashboard_content');
	}
})->middleware(['auth'])->name('dashboard');

Route::resource('/projects', ProjectController::class)->middleware(['auth']);
Route::get('/searchProject', [ProjectController::class, 'search'])->middleware(['auth']);
Route::get('/getprojectdash', [ProjectController::class, 'getprojectdash'])->middleware(['auth']);

Route::resource('/tasks', TaskController::class)->middleware(['auth']);
Route::get('/searchTask', [TaskController::class, 'search'])->middleware(['auth']);
Route::get('/gettaskdash', [TaskController::class, 'gettaskdash'])->middleware(['auth']);

Route::resource('/users', UserController::class)->middleware(['auth']);
Route::get('/searchUser', [UserController::class, 'search'])->middleware(['auth']);

Route::get('/type', [UserController::class, 'type'])->middleware(['auth']);
Route::get('/name', [UserController::class, 'name'])->middleware(['auth']);
Route::get('/changePassFrom', [UserController::class, 'changePassForm'])->middleware(['auth'])->name('changePassForm');
Route::post('/changePassword', [UserController::class, 'changePassword'])->middleware(['auth'])->name('changePassword');

require __DIR__.'/auth.php';
