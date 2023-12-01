<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PostController as AdminPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['checkRole:customer'])->group(function(){

    Route::resource('news',NewsController::class);
    Route::resource('post',PostController::class);


    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
});



Route::middleware(['checkRole:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::resource('news',AdminNewsController::class);
    Route::resource('post',AdminPostController::class);
    Route::post('/post/{post}',[AdminPostController::class,'update'])->name('post.updatePost');
    Route::post('/news/{news}',[AdminNewsController::class,'update'])->name('news.updatePost');

    Route::get('dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    });




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
