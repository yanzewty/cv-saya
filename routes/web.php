<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PortfolioController::class, 'index'])->name('portofolio.index');
Route::post('/contact/send', [PortfolioController::class, 'storeMessage'])->name('contact.send');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register/request', [LoginController::class, 'requestRegister'])->name('register.request');
Route::get('/register/verify', [LoginController::class, 'showVerify'])->name('register.verify');
Route::post('/register/verify', [LoginController::class, 'processVerify'])->name('register.process');


Route::get('/register/resend', [LoginController::class, 'resendOtp'])->name('register.resend'); 


Route::get('/forget-password', [LoginController::class, 'showForget'])->name('password.forget');
Route::post('/forget-password', [LoginController::class, 'sendResetOtp'])->name('password.email');
Route::get('/reset-password', [LoginController::class, 'showReset'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'processReset'])->name('password.update');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/edit', [PortfolioController::class, 'edit'])->name('portofolio.edit');
    Route::post('/admin/update', [PortfolioController::class, 'update'])->name('portofolio.update');
    Route::get('/admin/messages', [PortfolioController::class, 'messagesAdmin'])->name('admin.messages');
    Route::delete('/admin/messages/{id}', [PortfolioController::class, 'deleteMessage'])->name('admin.messages.delete');
});