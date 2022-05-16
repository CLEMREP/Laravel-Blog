<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;

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
    return view('index', ['title' => 'Main']);
})->name('index');

Route::get('/posts/', [PostController::class, 'index'])->name('user.posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('user.posts.show');

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/posts/', [AdminPostController::class, 'index'])->name('posts.index');

    Route::get('/posts/create', [AdminPostController::class, 'create'])->name('posts.create');
    Route::post('/posts/create', [AdminPostController::class, 'store'])->name('posts.store');
    
    Route::get('/posts/{post}', [AdminPostController::class, 'show'])->name('posts.show');

    Route::get('/posts/edit/{post}', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::post('/posts/edit/{post}', [AdminPostController::class, 'update'])->name('posts.update');

    Route::post('/posts/delete/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
