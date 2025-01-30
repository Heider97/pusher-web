<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ChannelController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');
    
Route::post('/pusher/auth', [AuthController::class, 'pusher'])
    ->middleware('auth:sanctum');

Route::post('/channels', [ChannelController::class, 'createChannel']);
Route::post('/channels/subscribe', [ChannelController::class, 'subscribe']);
Route::post('/channels/unsubscribe', [ChannelController::class, 'unsubscribe']);
Route::get('/channels/{id}/active-users', [ChannelController::class, 'activeUsers']);
