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
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/posts', function () {
        $post = new Post(
            [
                'title' => 'My first post',
                'content' => 'This is my first post content',
                'user_id' => auth()->id(),
            ]
        );

        $post->save();

        return Inertia::render('Post/Index', [
            'posts' => Post::orderBy('id', 'desc')->get(),
        ]);
    })->name('posts');

    Route::get('/jobs', function () {
        $jobs = DB::table('jobs')->orderBy('id', 'desc')->get();
        return Inertia::render('Jobs/Index', ['jobs' => $jobs]);
    })->name('jobs');
});
