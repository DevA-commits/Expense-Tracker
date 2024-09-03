<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

Route::group(['prefix' => '/expense', 'as' => 'admin.'], function () {
    Route::get('/', [ExpenseController::class, 'index'])->name('index');
    Route::post('/store', [ExpenseController::class, 'store'])->name('store');
    Route::post('/data-table', [ExpenseController::class, 'dataTable'])->name('table.datatable');
});

Route::group(['prefix' => '/report', 'as' => 'admin.'], function () {
    Route::get('/', [ReportController::class, 'index'])->name('report');
    Route::post('/data-table', [ReportController::class, 'dataTable'])->name('datatable');
    Route::get('/edit/{id}', [ReportController::class, 'edit'])->name('edit');
    Route::get('/list/{id}', [ReportController::class, 'list'])->name('list');
    Route::put('/update', [ReportController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ReportController::class, 'delete'])->name('delete');
});

