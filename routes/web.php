<?php

use App\Http\Controllers\Backend\AuthAdminController;
use App\Http\Controllers\Backend\CompanyProfileController;
use App\Http\Controllers\Backend\DashboardAdminController;
use App\Http\Controllers\Backend\MasterCustomerController;
use App\Http\Controllers\Backend\MasterUserController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\SummernoteController;
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
Route::get('/order/{order_number}', [OrderController::class, 'show'])->name('order.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::get('/policies/{code}', [HomeController::class, 'policies'])->name('policies');

Route::group(['middleware' => ['auth.customer']], function(){
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/my-order', [PanelOrderController::class, 'index'])->name('my-order');
    Route::get('/my-order/{order_number}', [PanelOrderController::class, 'show'])->name('my-order.show');
    Route::get('/my-order/{order_number}/cancel-order', [PanelOrderController::class, 'cancelOrder'])->name('my-order.cancel-order');
    Route::post('/my-order/load-data', [PanelOrderController::class, 'loadData'])->name('my-order.load-data');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.update-profile');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});


// Admin Panel
Route::group(['prefix' => 'paneladmin'], function(){
    Route::get('login', [AuthAdminController::class, 'login'])->name('paneladmin.login');
    Route::post('login', [AuthAdminController::class, 'loginProcess'])->name('paneladmin.login.process');
    Route::get('activation', [AuthAdminController::class, 'activation'])->name('paneladmin.activation');
    Route::post('activation-process', [AuthAdminController::class, 'activationProcess'])->name('paneladmin.activation.process');
    Route::get('activation/{email}/{code}', [AuthAdminController::class, 'registerActivationProcess'])->name('paneladmin.register.activation');
    Route::get('forgot-password', [AuthAdminController::class, 'forgotPassword'])->name('paneladmin.forgot-password');
    Route::post('forgot-password', [AuthAdminController::class, 'forgotPasswordProcess'])->name('paneladmin.forgot-password.process');
    Route::get('set-new-password/{email}/{code}', [AuthAdminController::class, 'setNewPassword'])->name('paneladmin.set-new-password');
    Route::post('set-new-password', [AuthAdminController::class, 'setNewPasswordProcess'])->name('paneladmin.set-new-password.process');

    Route::group(['middleware' => ['auth']], function(){
        Route::get('/', function(){
            return redirect()->route('paneladmin.dashboard');
        });
        Route::post('logout', [AuthAdminController::class, 'logout'])->name('paneladmin.logout');
        Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('paneladmin.dashboard');
        Route::post('dashboard/load-data', [DashboardAdminController::class, 'loadData'])->name('api.dashboard.load-data');
        
        // Master Data
        // master user
        Route::resource('master-user', MasterUserController::class);
        Route::post('master-user/load-data', [MasterUserController::class, 'loadData'])->name('api.master-user.load-data');
        Route::post('master-user/export', [MasterUserController::class, 'export'])->name('api.master-user.export');
        
        // master customer
        Route::get('master-customer', [MasterCustomerController::class, 'index'])->name('paneladmin.master-customer.index');
        Route::get('master-customer/{code}', [MasterCustomerController::class, 'show'])->name('paneladmin.master-customer.show');
        Route::get('master-customer/{code}/edit', [MasterCustomerController::class, 'edit'])->name('paneladmin.master-customer.edit');
        Route::put('master-customer/{code}', [MasterCustomerController::class, 'update'])->name('paneladmin.master-customer.update');
        Route::delete('master-customer/{code}', [MasterCustomerController::class, 'destroy'])->name('paneladmin.master-customer.destroy');
        Route::post('master-customer/load-data', [MasterCustomerController::class, 'loadData'])->name('api.master-customer.load-data');
        Route::post('master-customer/export', [MasterCustomerController::class, 'export'])->name('api.master-customer.export');
        
        // product
        Route::resource('product', ProductController::class);
        Route::post('product/load-data', [ProductController::class, 'loadData'])->name('api.product.load-data');
        Route::post('product/export', [ProductController::class, 'export'])->name('api.product.export');
        Route::get('product/main-product/{id}/{status}', [ProductController::class, 'mainProduct'])->name('api.product.main-product');
        
        // company-profile
        Route::get('company-profile/{code}', [CompanyProfileController::class, 'edit'])->name('company-profile.edit');
        Route::put('company-profile/{code}', [CompanyProfileController::class, 'update'])->name('company-profile.update');
    });
});

Route::prefix('universal')->group(function () {
    Route::post('summernote/upload', [SummernoteController::class,'upload'])->name('summernote.upload');
    Route::post('summernote/delete', [SummernoteController::class,'delete'])->name('summernote.delete');
});