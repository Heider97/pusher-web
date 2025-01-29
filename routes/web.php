<?php

use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
        //broadcast(new MessageEvent('hola a todos'))->toOthers();
        $post = new Post(
            [
                'title' => 'Post 1',
                'content' => 'Content 1',
                'user_id' => 1
            ]
        );

        $post->save();

        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/jobs', function () {
        $jobs = DB::table('jobs')->orderBy('id', 'desc')->get();
        return view('jobs.index', compact('jobs'));
    });
});
