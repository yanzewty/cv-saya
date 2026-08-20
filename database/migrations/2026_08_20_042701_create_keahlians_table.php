<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keahlians', function (Blueprint $table) {
            $table->id();
            $table->string('gambar')->nullable();   
            $table->string('modul')->nullable();    
            $table->string('judul')->nullable();    
            $table->string('kategori')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keahlians');
    }
};