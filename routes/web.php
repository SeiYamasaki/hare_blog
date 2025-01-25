<?php

use App\Http\Controllers\PostController; //作成
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PostController::class, 'index'])
    ->name('root'); ///にアクセスした場合、welcome.blade.phpが表示される
//PostControllerのindexアクションを呼び出すように修正します。まずは真っ白になる｡(Viewも作成していないため)

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts', PostController::class) //作成
    ->only(['create', 'store', 'edit', 'update', 'destroy']) //ログインしていないと使えない機能
    ->middleware('auth'); //制御

Route::resource('posts', PostController::class)
    ->only(['show', 'index']); //ログインしてなくても使える機能

require __DIR__ . '/auth.php';
