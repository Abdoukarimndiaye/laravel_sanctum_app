<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#Route::get('/user', function (Request $request) {
    #return $request->user();
#})->middleware('auth:sanctum')
;

use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::logout('/logout', [AuthController::class, 'logout']);


