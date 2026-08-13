<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'photo')) {
                $table->string('photo')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'gallery_1')) {
                $table->string('gallery_1')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'gallery_2')) {
                $table->string('gallery_2')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'gallery_3')) {
                $table->string('gallery_3')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'experience')) {
                $table->json('experience')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'skills')) {
                $table->json('skills')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['photo', 'gallery_1', 'gallery_2', 'gallery_3', 'experience', 'skills']);
        });
    }
};