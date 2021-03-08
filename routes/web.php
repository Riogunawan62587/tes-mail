<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('/chat', 'chat')->middleware('auth');
Route::view('/chat/{id}', 'chat')->middleware('auth');
Route::resource('users', UserController::class)->only([
    'index'
]);
Route::resource('messages', MessageController::class)->only([
    'index',
    'store',
    'show'
]);
