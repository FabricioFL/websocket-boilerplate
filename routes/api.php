<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
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

Route::get('/v1/', function(){
    return ['api' => 'websocket boilerplate', 'version' => 'v1.0.0'];
});

Route::post('/v1/user/signin', [UserController::class, 'signin']);

Route::post('/v1/user/signup', [UserController::class, 'create']);

Route::put('/v1/user/{id}/update', [UserController::class, 'update'])->middleware('jwt.auth');

Route::delete('/v1/user/{id}/delete', [UserController::class, 'delete'])->middleware('jwt.auth');

Route::get('/v1/user/{id}', [UserController::class, 'getById'])->middleware('jwt.auth');

Route::get('/v1/users/all', [UserController::class, 'index'])->middleware('jwt.auth');

Route::get('/v1/users/active', [UserController::class, 'indexByActive'])->middleware('jwt.auth');

Route::get('/v1/users/inactive', [UserController::class, 'indexByInactive'])->middleware('jwt.auth');

Route::get('/v1/user/{id}/points', [UserController::class, 'getPoints'])->middleware('jwt.auth');

Route::put('/v1/user/{id}/points/exchange', [UserController::class, 'pointsExchange'])->middleware('jwt.auth');

Route::get('/v1/payment/checkout', [PaymentController::class, 'checkout'])->middleware('jwt.auth');

Route::get('/v1/payment/add/method', [PaymentController::class, 'addMethod'])->middleware('jwt.auth');
