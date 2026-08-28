<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            
            // 1. KELOLA HOME (Identitas Utama)
            $table->string('foto_profil')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('judul_profesi')->nullable(); // Pengganti 'role'
            
            // 2. KELOLA HOME (Bio Singkat & Kontak)
            $table->text('bio_singkat')->nullable();     // Pengganti 'about'
            $table->string('email_publik')->nullable();  // Pengganti 'email'
            $table->string('nomor_telepon')->nullable(); // Pengganti 'phone'
            $table->string('alamat_lokasi')->nullable(); // Pengganti 'address'

           
            $table->string('teks_badge_1')->nullable();
            $table->string('teks_badge_2')->nullable();
            $table->text('banner_berjalan')->nullable(); // Pengganti 'skills'

            $table->string('tag_tentang_saya')->nullable();       // Pengganti 'about_sub_1'
            $table->string('judul_tentang_saya')->nullable();     // Pengganti 'about_title'
            $table->text('deskripsi_tentang_saya')->nullable();   // Pengganti 'about_1'
            
    

            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};