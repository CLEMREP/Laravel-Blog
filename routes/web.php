<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\AccountController as UserAccountController;
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

Route::get('/posts/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show')->middleware(['published']);

Route::middleware(['auth'])->group(function () {
    Route::get('/mon-compte', [UserAccountController::class, 'edit'])->name('account.edit');
    Route::post('/mon-compte', [UserAccountController::class, 'update'])->name('account.update');

    Route::middleware(['admin'])->name('admin.')->prefix('dashboard')->group(function () {
        Route::get('/posts/', [AdminPostController::class, 'index'])->name('posts.index');

        Route::get('/posts/create', [AdminPostController::class, 'create'])->name('posts.create');
        Route::post('/posts/create', [AdminPostController::class, 'store'])->name('posts.store');
        
        Route::get('/posts/{post}', [AdminPostController::class, 'show'])->name('posts.show');

        Route::get('/posts/edit/{post}', [AdminPostController::class, 'edit'])->name('posts.edit');
        Route::post('/posts/edit/{post}', [AdminPostController::class, 'update'])->name('posts.update');

        Route::post('/posts/delete/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');

        Route::get('/users/', [AdminUserController::class, 'index'])->name('users.index');

        Route::get('/users/edit/{user}', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::post('/users/edit/{user}', [AdminUserController::class, 'update'])->name('users.update');
    
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users/create', [AdminUserController::class, 'store'])->name('users.store');
    
        Route::post('/users/delete/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'admin'])->name('dashboard');

require __DIR__.'/auth.php';
