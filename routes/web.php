<?php

use App\Http\Controllers\Admin\AddUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserSetting;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});


Route::group((['prefix' => '/login', 'as' => 'admin.', 'middleware' => 'admin.guest']), function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
});

Route::group(['prefix' => '/', 'as' => 'admin.', 'middleware' => 'admin.auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
});

Route::group(['prefix' => '/expense', 'as' => 'admin.', 'middleware' => 'admin.auth'], function () {
    Route::get('/', [ExpenseController::class, 'index'])->name('index');
    Route::post('/store', [ExpenseController::class, 'store'])->name('store');
    Route::post('/data-table', [ExpenseController::class, 'dataTable'])->name('table.datatable');
});

Route::group(['prefix' => '/report', 'as' => 'admin.', 'middleware' => 'admin.auth'], function () {
    Route::get('/', [ReportController::class, 'index'])->name('report');
    Route::post('/data-table', [ReportController::class, 'dataTable'])->name('datatable');
    Route::get('/edit/{id}', [ReportController::class, 'edit'])->name('edit');
    Route::get('/list/{id}', [ReportController::class, 'list'])->name('list');
    Route::put('/update', [ReportController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ReportController::class, 'delete'])->name('delete');
    Route::post('/download-pdf', [ReportController::class, 'downloadPdf'])->name('download.report');
});

Route::group(['prefix' => '/user', 'as' => 'index.', 'middleware' => 'admin.auth'], function () {
    Route::get('/', [AddUserController::class, 'index'])->name('index');
    Route::post('/store', [AddUserController::class, 'store'])->name('store');
    Route::post('/data-table', [AddUserController::class, 'dataTable'])->name('datatable');
    Route::get('/edit/{id}', [AddUserController::class, 'edit'])->name('edit');
    Route::put('/update', [AddUserController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [AddUserController::class, 'delete'])->name('delete');
});


Route::group(['prefix' => '/user-setting', 'as' => 'user.', 'middleware' => 'admin.auth'], function () {
    Route::get('/', [UserSetting::class, 'index'])->name('setting');
    Route::post('/store', [UserSetting::class, 'store'])->name('store');
});


Route::group(['prefix' => '/user-payment', 'as' => 'user.payment.', 'middleware' => 'admin.auth'], function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::post('/store', [PaymentController::class, 'store'])->name('store');
    Route::post('/data-table', [PaymentController::class, 'dataTable'])->name('datatable');
    Route::get('/edit/{id}', [PaymentController::class, 'edit'])->name('edit');
    Route::put('/update', [PaymentController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PaymentController::class, 'delete'])->name('delete');
});