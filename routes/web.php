<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanSparepartController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::get('/sparepart/stok', [SparepartController::class, 'index'])->name('sparepart.stok');
    Route::get('/booking/saya', [BookingController::class, 'bookingSaya'])->name('booking.saya');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/edit/{id}', [BookingController::class, 'editOnline'])->name('booking.edit-online');
    Route::put('/booking/update/{id}', [BookingController::class, 'updateOnline'])->name('booking.update-online');
    Route::delete('/booking/hapus/{id}', [BookingController::class, 'destroyOnline'])->name('booking.destroy-online');
    Route::get('/booking/saya/nota/{id}', [BookingController::class, 'notaOnline'])->name('booking.nota-online');
    Route::post('/notifikasi/read/{id}', [UserNotificationController::class, 'read'])->name('notifikasi.read');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
        Route::get('/booking/histori', [BookingController::class, 'histori'])->name('booking.histori');
        Route::get('/booking/bayar/{id}', [BookingController::class, 'bayar'])->name('booking.bayar');
        Route::put('/booking/bayar/{id}', [BookingController::class, 'prosesBayar'])->name('booking.proses-bayar');
        Route::get('/booking/nota/{id}', [BookingController::class, 'nota'])->name('booking.nota');
        Route::delete('/booking/delete/{id}', [BookingController::class, 'destroy'])->name('booking.delete');

        Route::get('/sparepart', [PenjualanSparepartController::class, 'index'])->name('sparepart.index');
        Route::get('/sparepart/create', [PenjualanSparepartController::class, 'create'])->name('sparepart.create');
        Route::post('/sparepart/store', [PenjualanSparepartController::class, 'store'])->name('sparepart.store');
        Route::post('/sparepart/beli/{id}', [PenjualanSparepartController::class, 'beli'])->name('sparepart.beli');
        Route::get('/sparepart/nota/{id}', [PenjualanSparepartController::class, 'nota'])->name('sparepart.nota');
        Route::get('/sparepart/edit/{id}', [PenjualanSparepartController::class, 'edit'])->name('sparepart.edit');
        Route::put('/sparepart/update/{id}', [PenjualanSparepartController::class, 'update'])->name('sparepart.update');
        Route::delete('/sparepart/delete/{id}', [PenjualanSparepartController::class, 'destroy'])->name('sparepart.delete');
    });
});
