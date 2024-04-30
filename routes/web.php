<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PatientController;
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
Route::get('/', function () {return view('welcome');});

Route::get('/dashboard', function () {return view('layouts.doctor.app');});

Route::group(['middleware' => 'guest'],function()
{
    Route::get('/login',[AuthController::class,'index'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('login')->middleware('throttle:2,1');

    Route::get('/register',[AuthController::class,'register_view'])->name('registeruser');
    Route::post('/register',[AuthController::class,'register'])->name('register')->middleware('throttle:2,1');

});


Route::group(['middleware' => 'auth'],function()
{
    //Authenticated User Routes
    
    Route::post('/upload-image', [ImageController::class, 'upload']);
    Route::get('/home',[AuthController::class,'home'])->name('home');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');

    //Dashboard routes

    Route::get('/admin/dashboard', [AuthController::class, 'admin_dashboard'])->name('admin.dashboard');
    Route::get('/doctor/dashboard', [AuthController::class, 'doctor_dashboard'])->name('doctor.dashboard');

    Route::get('/doctors/patients', [PatientController::class, 'index'])->name('admin.doctors.patients.index');
});

//Stripe Routes

// Route::get('/', [StripeController::class,'checkout'])->name('checkout');
Route::post('/session', [StripeController::class,'session'])->name('session');
Route::get('/success', [StripeController::class,'session'])->name('success');
