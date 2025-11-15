<?php

use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\Panel\DashboardController;
use App\Http\Controllers\Frontend\Panel\OrderController as PanelOrderController;
use App\Http\Controllers\Frontend\Panel\ProfileController;
use App\Http\Controllers\Frontend\Panel\SampleController as PanelSampleController;
use App\Http\Controllers\Frontend\PortofolioController;
use App\Http\Controllers\Frontend\SampleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
Route::get('/register/activation/{email}/{code}', [AuthController::class, 'registerActivationProcess'])->name('register.activation');
Route::get('/activation', [AuthController::class, 'activation'])->name('activation');
Route::post('/activation-process', [AuthController::class, 'activationProcess'])->name('activation.process');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPasswordProcess'])->name('forgot-password.process');
Route::get('/set-new-password/{email}/{code}', [AuthController::class, 'setNewPassword'])->name('set-new-password');
Route::post('/set-new-password', [AuthController::class, 'setNewPasswordProcess'])->name('set-new-password.process');

Route::get('/showcase', [PortofolioController::class, 'index'])->name('showcase');
Route::get('/showcase/{slug}', [PortofolioController::class, 'detail'])->name('showcase.detail');
Route::get('/sample', [SampleController::class, 'index'])->name('sample');
Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::post('/order', [OrderController::class, 'store'])->name('order.process');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');

Route::group(['middleware' => ['auth.customer']], function(){
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-sample', [PanelSampleController::class, 'index'])->name('my-sample');
    Route::get('/my-order', [PanelOrderController::class, 'index'])->name('my-order');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

