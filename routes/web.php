<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// ==========================================
// RUTE HALAMAN PUBLIK (Bisa diakses siapa saja)
// ==========================================

// Halaman Utama Portofolio
Route::get('/', [PortfolioController::class, 'index'])->name('portofolio.index');

// Rute Pengiriman Pesan (Contact / Send a Message)
Route::post('/contact/send', [PortfolioController::class, 'storeMessage'])->name('contact.send');


// ==========================================
// RUTE AUTENTIKASI (Halaman Login Admin)
// ==========================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ==========================================
// RUTE KHUSUS ADMIN (Dilindungi Satpam/Middleware)
// Orang yang belum login TIDAK AKAN BISA masuk ke rute ini!
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Kelola Data Portofolio
    Route::get('/admin/edit', [PortfolioController::class, 'edit'])->name('portofolio.edit');
    Route::post('/admin/update', [PortfolioController::class, 'update'])->name('portofolio.update');
    
    // Kelola Pesan Masuk
    Route::get('/admin/messages', [PortfolioController::class, 'messagesAdmin'])->name('admin.messages');
    Route::delete('/admin/messages/{id}', [PortfolioController::class, 'deleteMessage'])->name('admin.messages.delete');
});