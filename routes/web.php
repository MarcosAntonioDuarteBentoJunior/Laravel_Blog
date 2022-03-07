<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;
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

Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('/home', [PagesController::class, 'index'])->name('home');

Route::post('/blog/search/', [PostsController::class, 'search'])->name('blog.search');
Route::get('blog/my-posts', [PostsController::class, 'myPosts'])->name('blog.myPosts')->middleware('auth');
Route::resource('blog', PostsController::class);

Route::get('category/{slug}/posts', [CategoryController::class, 'posts'])->name('category.posts');
Route::resource('category', CategoryController::class)->middleware('auth');

Auth::routes();


