<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\UserDownloadController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserLocationController;
use App\Http\Controllers\MunicipalityController;

// Redirect root to login page

Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'index'])->name('login.form');
Route::post('/login', [LoginController::class, 'customLogin'])->middleware('throttle:6,1')->name('login');
Route::post('/logout', [LoginController::class, 'signOut'])->name('logout');

// Admin routes
Route::middleware('admin')->group(function () {
    // Dashboard and Location Routes
    Route::get('/download', [DownloadController::class, 'index'])->name('admin.download');
    Route::get('/admin/locations', [LocationController::class, 'index'])->name('admin.location');
    Route::delete('/locations/{id}', [LocationController::class, 'destroy'])->name('locations.destroy');
    Route::get('/admin/index', [LocationController::class, 'dashboard'])->name('admin.index');
    Route::get('/admin/report', [LocationController::class, 'report'])->name('admin.report');
    Route::get('admin/report/export', [LocationController::class, 'export'])->name('admin.report.export');
    Route::get('/dashboard-data', [LocationController::class, 'getDashboardData'])->name('dashboard.data');



    // User Management Routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.adduser');



    Route::get('/admin/municipal/create', [MunicipalityController::class, 'create'])->name('admin.municipal.create');
    Route::post('/admin/municipal', [MunicipalityController::class, 'store'])->name('admin.municipal.store');
    Route::get('/admin/municipality', [MunicipalityController::class, 'index'])->name('admin.municipal');
    Route::delete('/admin/municipality/{id}', [MunicipalityController::class, 'destroy'])->name('admin.municipal.destroy');


    // Optional: User resource routes
    Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
});

// User dashboard routes
Route::middleware(['user','auth'])->group(function () {
    Route::get('/user/index', [UserLocationController::class, 'index'])->name('user.index');
    Route::get('/user/locations', [UserLocationController::class, 'index'])->name('user.locations');
    Route::post('/user/locations', [UserLocationController::class, 'store'])->name('user-save-location');
    Route::get('/user/download', [UserDownloadController::class, 'index'])->name('user.download');
});




