<?php

use App\Http\Controllers\TaskManagementController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 
Route::post('/user/signup', [UserController::class, 'addUser']);
Route::post('/user/login', [UserController::class, 'login']);

Route::post('project/add', [TaskManagementController::class, 'addproject']);
Route::post('project/addtask', [TaskManagementController::class, 'addTask']);
Route::get('project/get', [TaskManagementController::class, 'getProject']);

Route::post('status/add', [TaskManagementController::class, 'addStatus']);




Route::group([

    'middleware' => ["auth:api"],

], function () {
    Route::post('/refresh', [UserController::class, 'refresh']);
    Route::post('/profile', [UserController::class, 'profile']);
    Route::post('/logout', [UserController::class, 'logout']);
});


Route::post('/task/addworker', [TaskManagementController::class, 'addUserInProject']);
Route::post('/task/updatestatus', [TaskManagementController::class, 'editStatusTask']);
Route::post('/task/updatepermission', [TaskManagementController::class, 'editPermission']);
Route::post('/task/updatedealine', [TaskManagementController::class, 'editDealine']);









// add maorings

Route::post('/majoring/add', [UserController::class, 'addMajoring']);
Route::get('/majoring/get', [UserController::class, 'getMajoring']);

