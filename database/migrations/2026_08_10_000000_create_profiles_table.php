<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->text('about');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            
            // Tambahkan kolom untuk foto profil & galeri di sini
            $table->string('photo')->nullable();
            $table->string('gallery_1')->nullable();
            $table->string('gallery_2')->nullable();
            $table->string('gallery_3')->nullable();

            $table->json('skills')->nullable();
            $table->json('education')->nullable();
            $table->json('experiences')->nullable();
            $table->json('hobbies')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};