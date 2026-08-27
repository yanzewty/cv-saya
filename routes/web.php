<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portofolio.index');

// throttle (satpam anti-spam) di rute contact ini!
Route::post('/contact/send', [PortfolioController::class, 'storeMessage'])
    ->name('contact.send')
    ->middleware('throttle:3,3'); // Maksimal 3 request per 3 menit ini buat time limited mamps

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

Route::middleware(['auth'])->prefix('admin')->group(function () {
Route::get('/', [PortfolioController::class, 'dashboard'])->name('admin.dashboard');

    // 1. KELOLA HOME
    Route::get('/home', [PortfolioController::class, 'editHome'])->name('admin.home');
    Route::post('/home/update', [PortfolioController::class, 'updateHome'])->name('admin.home.update');

    // 2. KELOLA ABOUT UTAMA
    Route::get('/about', [PortfolioController::class, 'editAbout'])->name('admin.about');
    Route::post('/about', [PortfolioController::class, 'updateAbout'])->name('admin.about.update');

    // 3. KELOLA LATAR BELAKANG SKILL (Kartu 3D)
    Route::get('/latar-belakang-skill', [PortfolioController::class, 'keahlianAdmin'])->name('admin.latar_belakang');
    Route::post('/latar-belakang-skill', [PortfolioController::class, 'keahlianStore'])->name('admin.latar_belakang.store');
    Route::get('/latar-belakang-skill/{id}/edit', [PortfolioController::class, 'keahlianEdit'])->name('admin.latar_belakang.edit');
    // Pakai PUT biar sesuai sama form <form method="POST"> + @method('PUT')
    Route::put('/latar-belakang-skill/{id}', [PortfolioController::class, 'keahlianUpdate'])->name('admin.latar_belakang.update'); 
    Route::delete('/latar-belakang-skill/{id}', [PortfolioController::class, 'keahlianDestroy'])->name('admin.latar_belakang.delete');
    Route::post('/latar-belakang-skill/header', [PortfolioController::class, 'updateSkillHeader'])->name('admin.latar_belakang.header');

    // 4. KELOLA BIDANG KEAHLIAN (Slider Kotak-kotak)
    Route::get('/bidang-keahlian', [PortfolioController::class, 'bidangKeahlianAdmin'])->name('admin.keahlian');
    Route::post('/bidang-keahlian/update', [PortfolioController::class, 'updateBidangKeahlian'])->name('admin.bidang_keahlian.update');

    // 5. KELOLA ORGANISASI (Zigzag)
    Route::get('/organizations', [PortfolioController::class, 'orgAdmin'])->name('admin.organizations');
    Route::post('/organizations', [PortfolioController::class, 'updateOrgAdmin'])->name('admin.organizations.update');

    // 6. KELOLA PANELS (Section Tambahan Dinamis)
    Route::post('/panels', [PortfolioController::class, 'panelStore'])->name('admin.panels.store');
    Route::get('/panels/{id}/edit', [PortfolioController::class, 'panelEdit'])->name('admin.panels.edit');
    Route::post('/panels/{id}/update', [PortfolioController::class, 'panelUpdate'])->name('admin.panels.update');
    Route::delete('/panels/{id}', [PortfolioController::class, 'panelDestroy'])->name('admin.panels.delete');

    // 7. KELOLA PESAN MASUK
    Route::get('/messages', [PortfolioController::class, 'messagesAdmin'])->name('admin.messages');
    Route::delete('/messages/{id}', [PortfolioController::class, 'deleteMessage'])->name('admin.messages.delete');
    // Fitur Read Message
    Route::patch('/messages/read-all', [PortfolioController::class, 'markAllAsRead'])->name('admin.messages.readAll');
    Route::patch('/messages/{id}/read', [PortfolioController::class, 'markAsRead'])->name('admin.messages.read');

    // 8. KELOLA PROYEK & GALERI
    Route::get('/projects', [PortfolioController::class, 'projectsAdmin'])->name('admin.projects');
    Route::get('/projects/create', [PortfolioController::class, 'projectCreate'])->name('admin.projects.create');
    Route::post('/projects', [PortfolioController::class, 'projectStore'])->name('admin.projects.store');
    Route::delete('/projects/{id}', [PortfolioController::class, 'projectDestroy'])->name('admin.projects.delete');

    // Rute untuk aksi massal (Select )
    Route::delete('/messages/bulk-delete', [PortfolioController::class, 'bulkDeleteMessages'])->name('admin.messages.bulkDelete');
    Route::patch('/messages/bulk-read', [PortfolioController::class, 'bulkReadMessages'])->name('admin.messages.bulkRead');



});