<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_panels', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->nullable();   // Contoh: 01.1 / LAYANAN
            $table->string('title')->nullable(); // Contoh: Judul Kotak Tambahan
            $table->string('sub_1')->nullable(); // Judul list 1
            $table->text('desc_1')->nullable();  // Deskripsi list 1
            $table->string('sub_2')->nullable();
            $table->text('desc_2')->nullable();
            $table->string('sub_3')->nullable();
            $table->text('desc_3')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_panels');
    }
};