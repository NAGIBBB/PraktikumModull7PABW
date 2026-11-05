<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\TrafficReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Modul 7 Subbab 7.4.4: CRUD Berkas (Laravel Breeze)
    Route::resource('uploads', UploadController::class);

    // Modul 7 Subbab 7.5 No 2: CRUD Tugas Akhir SmartTraffic Finder dengan Upload File
    Route::resource('traffic-reports', TrafficReportController::class);
});

require __DIR__.'/auth.php';
