<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StripeController;

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
// Route::get('/', function () {return view('welcome');});



Route::group(['middleware' => 'guest'],function()
{
    Route::get('/login',[AuthController::class,'index'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('login')->middleware('throttle:2,1');

    Route::get('/register',[AuthController::class,'register_view'])->name('registeruser');
    Route::post('/register',[AuthController::class,'register'])->name('register')->middleware('throttle:2,1');

});


Route::group(['middleware' => 'auth'],function()
{
    Route::post('/upload-image', [ImageController::class, 'upload']);
    Route::get('/home',[AuthController::class,'home'])->name('home');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});

Route::get('/', [StripeController::class,'checkout'])->name('checkout');

Route::post('/session', [StripeController::class,'session'])->name('session');

Route::get('/success', [StripeController::class,'session'])->name('success');