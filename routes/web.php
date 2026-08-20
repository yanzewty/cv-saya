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

// ========================================================
// GRUP ADMIN (Sudah ada prefix /admin, jadi di dalamnya nggak perlu ditulis /admin lagi)
// ========================================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    Route::get('/', function() {
        return redirect()->route('admin.home');
    })->name('admin.dashboard');

    // 1. KELOLA HOME
    Route::get('/home', [PortfolioController::class, 'editHome'])->name('admin.home');
    Route::post('/home/update', [PortfolioController::class, 'updateHome'])->name('admin.home.update');

    // 2. KELOLA ABOUT UTAMA
    Route::get('/about', [PortfolioController::class, 'editAbout'])->name('admin.about');
    Route::post('/about', [PortfolioController::class, 'updateAbout'])->name('admin.about.update');

    // 3. KELOLA ORGANISASI
    Route::get('/organizations', [PortfolioController::class, 'orgAdmin'])->name('admin.organizations');

    // 4. KELOLA PESAN MASUK
    Route::get('/messages', [PortfolioController::class, 'messagesAdmin'])->name('admin.messages');
    Route::delete('/messages/{id}', [PortfolioController::class, 'deleteMessage'])->name('admin.messages.delete');

    // 5. KELOLA PROYEK & GALERI
    Route::get('/projects', [PortfolioController::class, 'projectsAdmin'])->name('admin.projects');
    Route::get('/projects/create', [PortfolioController::class, 'projectCreate'])->name('admin.projects.create');
    Route::post('/projects', [PortfolioController::class, 'projectStore'])->name('admin.projects.store');
    Route::delete('/projects/{id}', [PortfolioController::class, 'projectDestroy'])->name('admin.projects.delete');
    
    // 6. KELOLA PANELS (Section Tambahan Dinamis)
    Route::post('/panels', [PortfolioController::class, 'panelStore'])->name('admin.panels.store');
    Route::get('/panels/{id}/edit', [PortfolioController::class, 'panelEdit'])->name('admin.panels.edit');
    Route::post('/panels/{id}/update', [PortfolioController::class, 'panelUpdate'])->name('admin.panels.update');
    Route::delete('/panels/{id}', [PortfolioController::class, 'panelDestroy'])->name('admin.panels.delete');
    
    // 7. KELOLA LATAR BELAKANG SKILL (URL sudah diganti jadi /latar-belakang-skill)
    Route::get('/latar-belakang-skill', [PortfolioController::class, 'keahlianAdmin'])->name('admin.keahlian');
    Route::post('/latar-belakang-skill', [PortfolioController::class, 'keahlianStore'])->name('admin.keahlian.store');
    Route::get('/latar-belakang-skill/{id}/edit', [PortfolioController::class, 'keahlianEdit'])->name('admin.keahlian.edit');
    Route::post('/latar-belakang-skill/{id}/update', [PortfolioController::class, 'keahlianUpdate'])->name('admin.keahlian.update');
    Route::delete('/latar-belakang-skill/{id}', [PortfolioController::class, 'keahlianDestroy'])->name('admin.keahlian.delete');
    Route::post('/latar-belakang-skill/header', [PortfolioController::class, 'updateSkillHeader'])->name('admin.keahlian.header');
});