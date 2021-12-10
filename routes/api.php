<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('v1/auth',[AuthController::class,'login']);




Route::prefix('v1')->middleware('auth:api')->group(function(){
       Route::get('/users',[UserController::class,'index']);

       Route::get('/users/{id}',[UserController::class,'show']);
       Route::delete('/users/{id}',[UserController::class,'destroy']);

       Route::post('/users',[UserController::class,'store']);
       Route::patch('/users/{id}',[UserController::class,'update']);
});



