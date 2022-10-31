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

    Route::get('/board/show/{id}', [Boardcontroller::class, 'show']);
    Route::post('/board/create/{id}', [Boardcontroller::class, 'store']);
    Route::resource('/task', Taskcontroller::class);
    Route::resource('/subtask', Subtaskcontroller::class);
    Route::get('/Logout', [Usercontroller::class, 'Logout']);


});

// Sign up Route
Route::post('/register', [Usercontroller::class, 'Register']);


//login Route
Route::post('/Login', [Usercontroller::class, 'Login']);

