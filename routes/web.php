<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardBlogsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteController;
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
})->name('home');

Route::get('/blogs', [SiteController::class, "blogs"])->middleware(['auth', 'verified'])->name('blogs');
Route::get('/blog/{blogs:slug}', [SiteController::class, "blog"])->middleware(['auth', 'verified'])->name('blog');

Route::get('/dashboard', [DashboardController::class, "index"])->middleware(['auth', 'verified'])->name("dashboard");
Route::resource('/dashboard/blogs', DashboardBlogsController::class)->middleware(['auth', 'verified']);

// Blog API
Route::post('/like-blog/{id}',[BlogController::class,'likeBlog'])->name('like.blog');
Route::post('/comment/{id}', [BlogController::class,'comment'])->name('comment.blog');
Route::post('/update-comments/{id}', [BlogController::class,'updateComments'])->name('updatecomments.blog');
Route::post('/rules-confirmed', [BlogController::class, 'isRulesConfirmed'])->name("rulesconfirmed.blog");
Route::post('/set-rules-confirmed', [BlogController::class, "setRulesConfirmed"])->name("setrulesconfirmed.blog");
Route::post('/send-comment-report/{id}', [BlogController::class, "sendCommentReport"])->name("sendcommentreport");
// End Blog API

Route::get('/categories', function () {
    return Inertia::render('Categories');
})->middleware(['auth', 'verified'])->name('categories');

require __DIR__.'/auth.php';