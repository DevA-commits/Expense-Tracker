<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ReportController;
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
});

