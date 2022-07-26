<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\SiteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function() {
    return redirect()->route('blogs');
});

Route::get('/home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/blogs', [SiteController::class, "blogs"])->middleware(['auth', 'verified'])->name('blogs');
Route::get('/blog/{blogs:slug}', [SiteController::class, "blog"])->middleware(['auth', 'verified'])->name('blog');

Route::post('/like-blog/{id}',[BlogController::class,'likeBlog'])->name('like.blog');
Route::post('/unlike-blog/{id}',[BlogController::class,'unlikeblog'])->name('unlike.blog');
Route::post('/get-like/{id}',[BlogController::class,'getLikeBlog'])->name('getlike.blog');

Route::get('/categories', function () {
    return Inertia::render('Categories');
})->middleware(['auth', 'verified'])->name('categories');

require __DIR__.'/auth.php';
