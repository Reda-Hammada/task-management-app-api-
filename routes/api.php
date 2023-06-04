<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\Boardcontroller;
use App\Http\Controllers\Taskcontroller;
use App\Http\Controllers\Phasecontroller;
use App\Http\Controllers\Subtaskcontroller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});

// Auth::routes(['verify' => true]);



Route::fallback(function (){
    abort(404, 'API resource not found');
});

//Protected routes
Route::group(['middleware'=>['auth:sanctum','throttle:90,1']], function(){
    Route::get('/boards/{boardId}/phases/tasks', [Boardcontroller::class, 'show']);
    // Board api routes 
    Route::get('/boards/user/{userId}', [Boardcontroller::class, 'index']);
    Route::put('/boards/{id}', [Boardcontroller::class, 'update']);
    Route::post('/boards/user/{userId}', [Boardcontroller::class, 'store']);
    Route::delete('/boards/{id}', [Boardcontroller::class, 'destroy']);

    // Phase api route 
    Route::get('/phase/{id}', [Phasecontroller::class, 'index']);
    Route::post('/boards/phases/{boardId}',[Phasecontroller::class, 'store']);
    Route::put('/phases/{id}', [Phasecontroller::class, 'update']);
    Route::delete('/phases/{id}',[Phasecontroller::class,'destroy']);
    
    //Task api route
    Route::get('/task/{id}', [Taskcontroller::class,'index']);
    Route::post('/phases/tasks/{phaseId}',[Taskcontroller::class,'store']);
    Route::put('/tasks/{id}',[Taskcontroller::class,'update']);
    Route::delete('/tasks/{id}',[Taskcontroller::class,'destroy']);
 
    //Subtask api route 
    Route::post('/tasks/subtask/{taskId}', [Subtaskcontroller::class, 'store']);
    Route::get('/tasks/subtasks/{taskId}', [Subtaskcontroller::class, 'index']);
    Route::put('/subtasks/{id}', [Subtaskcontroller::class, 'update']);
    Route::delete('/subtasks/{id}', [Subtaskcontroller::class, 'destroy']);

    // user route logout & update   
    Route::get('/Logout', [Usercontroller::class, 'Logout']);
    Route::put('/user/{userId}',[Usercontroller::class, 'updateUserInfo']);

});

// Sign up Route
Route::post('/register', [Usercontroller::class, 'Register']);


//login Route
Route::post('/Login', [Usercontroller::class, 'login']);