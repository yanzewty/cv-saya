<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Resmi untuk Login
        User::updateOrCreate(
            ['email' => 'yanzewty@gmail.com'],
            [
                'name' => 'Alfiansyah Ibdani',
                'password' => Hash::make('password123'),
            ]
        );

        
        $this->call(ProfileSeeder::class);
    }
}