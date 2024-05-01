<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
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

Route::get('/',[AuthController::class,'home'])->name('home');

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

    //stripe control
    Route::post('/session', [StripeController::class,'session'])->name('session');
    Route::get('/success', [StripeController::class,'success'])->name('success');

    //Dashboard routes

    Route::get('/admin/dashboard', [AuthController::class, 'admin_dashboard'])->name('admin.dashboard');
    Route::get('/doctor/dashboard', [AuthController::class, 'doctor_dashboard'])->name('doctor.dashboard');

    Route::get('/doctors/patients', [PatientController::class, 'index'])->name('admin.doctors.patients.index');
    Route::post('/doctors/patients/{id}', [PatientController::class, 'update'])->name('admin.doctors.patients.update');
    Route::post('/doctors/patients/delete/{id}', [PatientController::class, 'delete'])->name('admin.doctors.patients.delete');

    Route::get('/doctors/patients/reports', [ReportController::class, 'index'])->name('admin.doctors.patients.reports');
    Route::post('/doctors/patients/reports/{id}', [ReportController::class, 'update'])->name('admin.doctors.patients.reports.update');
    
});

//Stripe Routes


