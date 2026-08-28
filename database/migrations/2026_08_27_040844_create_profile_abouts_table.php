<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_abouts', function (Blueprint $table) {
            $table->id();
            // Menyambungkan About ini ke Profil siapa
            $table->foreignId('profile_id')->constrained()->onDelete('cascade'); 

            // Penanda: true = data About utama (cuma 1), false = section tambahan (bisa banyak)
            $table->boolean('is_main')->default(false);
            
            // Kolom dinamis (bisa diisi apa saja tanpa perlu bikin kolom _1, _2, _3)
            $table->string('tag')->nullable();         //Contoh: "03 / KEAHLIAN"
            $table->string('title')->nullable();       //Contoh: "Bidang Keahlian Saya"
            $table->string('subtitle')->nullable();    //Contoh: "Web Developer"
            $table->text('description')->nullable();   //Contoh: "Saya bisa Laravel..."
        
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_abouts');
    }
};