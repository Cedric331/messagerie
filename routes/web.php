<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\MessageController;

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


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/user/auth', [HomeController::class, 'user'])->name('user');
Route::post('/user/avatar', [UserController::class, 'avatar']);

Route::get('/chat/{channel}', [MessageController::class, 'index'])->name('chat');
Route::post('/message/post', [MessageController::class, 'store']);
Route::post('/fetch/message', [MessageController::class, 'messages']);
Route::post('/notification/channel', [MessageController::class, 'notification']);
Route::post('/delete/image', [MessageController::class, 'deleteUpload']);
Route::post('/upload/image', [ImageController::class, 'upload']);

Route::post('/member/search', [ChannelController::class, 'searchMember']);
Route::post('/member/add', [ChannelController::class, 'addMember']);
Route::post('/member/remove', [ChannelController::class, 'removeMember']);
Route::post('/search/channel', [ChannelController::class, 'searchChannel']);
Route::post('/join/channel', [ChannelController::class, 'joinChannel']);

Route::get('/create', [ChannelController::class, 'create'])->name('chat-create');
Route::post('/create', [ChannelController::class, 'store']);
Route::post('/channel/remove', [ChannelController::class, 'delete']);

Route::get('/account', [UserController::class, 'index'])->name('account')->middleware('auth');
Route::post('/account', [UserController::class, 'update'])->middleware('auth');
Route::post('/account/delete', [UserController::class,'delete'])->middleware('auth');