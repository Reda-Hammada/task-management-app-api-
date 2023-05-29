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
    Route::get('/boards/{boardId}/phases/tasks/subtasks/', [Boardcontroller::class, 'show']);
    // Board api routes 
    Route::get('/boards/user/{userId}', [Boardcontroller::class, 'index']);
    Route::put('/boards/{id}', [Boardcontroller::class, 'update']);
    Route::post('/boards/user/{userId}', [Boardcontroller::class, 'store']);
    Route::delete('/board/destroy/{id}', [Boardcontroller::class, 'destroy']);

    // Phase api route 
    Route::get('/phase/{id}', [Phasecontroller::class, 'index']);
    Route::post('/phase/{boardId}',[Phasecontroller::class, 'store']);
    Route::put('/phase/{id}', [Phasecontroller::class, 'update']);
    Route::delete('/phase/{id}',[Phasecontroller::class,'destroy']);
    
    //Task api route
    Route::get('/task/{id}', [Taskcontroller::class,'index']);
    Route::post('/task/{phaseId}',[Taskcontroller::class,'store']);
    Route::put('/task/{id}',[Taskcontroller::class,'update']);
    Route::delete('/task/{id}',[Taskcontroller::class,'destroy']);
 
    //Subtask api route 
    Route::post('/subtask/{taskId}', [Subtaskcontroller::class, 'store']);
    Route::get('/subtask/{id}', [Subtaskcontroller::class, 'index']);
    Route::put('/subtask/{id}', [Subtaskcontroller::class, 'update']);
    Route::delete('/subtask/{id}', [Subtaskcontroller::class, 'destroy']);

    // user route logout & update   
    Route::get('/Logout', [Usercontroller::class, 'Logout']);
    Route::put('/user/{userId}',[Usercontroller::class, 'updateUserInfo']);

});

// Sign up Route
Route::post('/register', [Usercontroller::class, 'Register']);


//login Route
Route::post('/Login', [Usercontroller::class, 'login']);