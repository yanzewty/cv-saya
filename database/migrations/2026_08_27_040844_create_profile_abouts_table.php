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

          
            $table->boolean('is_main')->default(false);
            
           
            $table->string('tag')->nullable();        
            $table->string('title')->nullable();      
            $table->string('subtitle')->nullable();  
            $table->text('description')->nullable();  
        
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_abouts');
    }
};