<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\Boardcontroller;
use App\Http\Controllers\Taskcontroller;
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


Route::fallback(function (){
    abort(404, 'API resource not found');
});

//Protected routes
Route::group(['middleware'=>['auth:sanctum']], function(){

    Route::resource('/board', Boardcontroller::class);
    Route::resource('/task', Boardcontroller::class);
    Route::resource('/subtask', Boardcontroller::class);
    Route::get('/logout', [Usercontroller::class, 'logout']);


});

// Sign up Route
Route::post('/register', [Usercontroller::class, 'Register']);


//login Route
Route::get('/login', [Usercontroller::class, 'login']);

