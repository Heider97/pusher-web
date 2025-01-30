<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChannelController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::webhooks('paystack/webhook');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('posts', PostController::class);

    Route::get('/jobs', function () {
        $jobs = DB::table('jobs')->orderBy('id', 'desc')->get();
        return Inertia::render('Jobs/Index', ['jobs' => $jobs]);
    })->name('jobs');

    Route::get('/channels/active-users', [ChannelController::class, 'getChannelsWithActiveUsers']);

    Route::get('/channels', function () {
        return Inertia::render('Channels/Index');
    })->name('channels');
});


