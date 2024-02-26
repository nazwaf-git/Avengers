<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\StreamlineController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::post('login-in', [App\Http\Controllers\Auth\LoginController::class, 'authenticate']);

Route::get('/member', function () {
    return view('member.index');
});
Route::resource('memberAjax', MemberController::class);

Route::get('/streamline', function () {
    return view('streamline.index');
});
Route::resource('streamlineAjax', StreamlineController::class);
Route::get('/streamline', [StreamlineController::class, 'getMember']);

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');