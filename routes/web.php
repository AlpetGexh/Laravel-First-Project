<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;


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

Route::get('/', [MainController::class, 'showBallina'])->name('ballina'); //Index
Route::get('/{user:username}', [MainController::class, 'showUser'])->name('user.show'); //User Profile
Route::get('/kategoria/{category:slug}', [MainController::class, 'showCategory'])->name('category.single'); //Single Category

// Post
Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
    Route::get('/{post:slug}', [MainController::class, 'show'])->name('single'); //Single Post
    Route::get('/edit/{post:slug}', [MainController::class, 'postEdit'])->name('edit')->middleware(['auth:sanctum', 'verified']); //Edit Post

});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['can:admin_show']], function () {
    Route::middleware(['auth:sanctum', 'verified',])->group(function () {
        Route::get('/dashboard',  [MainController::class, 'showAdminDashboard'])->name('dashboard');
        Route::get('/categorys',  [MainController::class, 'showAdminCategory'])->name('category')->middleware('can:category_show');
        Route::get('/subcategorys',  [MainController::class, 'showAdminSubCategory'])->name('subcategory')->middleware('can:category_show');
        Route::get('/posts',  [MainController::class, 'showAdminPost'])->name('post')->middleware('can:post_show');
        Route::get('/roles',  [MainController::class, 'showAdimRole'])->name('role')->middleware('can:role_show');
        Route::get('/users',  [MainController::class, 'showAdminUser'])->name('user')->middleware('can:user_show');
    });
});

// Users
Route::group(['prefix' => 'user'], function () {
    Route::middleware(['auth:sanctum', 'verified',])->group(function () {
        Route::group(['as' => 'post.'], function () {
            Route::get('/createpost', [MainController::class, 'showCreatePost'])->name('create');
            Route::get('/likes', [MainController::class, 'showPostLike'])->name('like');
            Route::get('/saves', [MainController::class, 'showPostSave'])->name('save');
        });
    });
    Route::get('/chat',  [MainController::class, 'showChat'])->name('user.chat');
});



// Route::get('/user/chat/{follow:chat_id}', [MainController::class , 'showChatId'])->name('chat.show');
