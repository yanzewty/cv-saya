<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Alfiansyah Ibdani',
                'role' => 'Fullstack Developer & IT Enthusiast',
                'about' => 'Siswa Kelas 12 SMK Negeri 1 Surabaya yang memiliki ketertarikan mendalam pada pengembangan web, jaringan komputer, serta aktif dalam kegiatan organisasi kepemudaan. Saya senang memecahkan masalah teknis secara logis.',
                'email' => 'yanzewty@gmail.com',
                'phone' => '0882-3592-1495',
                'address' => 'Perumahan Palempertiwi, Menganti, Gresik, Jawa Timur',
                'skills' => ['PHP', 'Laravel', 'Tailwind CSS', 'JavaScript', 'Networking'],
                'hobbies' => ['Eksplorasi Teknologi', 'Gaming Conqueror', 'Organisasi Sosial'],
                'experience' => [
                    [
                        'period' => '2025 - Sekarang',
                        'title' => 'Sekretaris Umum OSIS',
                        'place' => 'SMK Negeri 1 Surabaya',
                        'desc' => 'Bertanggung jawab penuh atas administrasi organisasi, tata kelola surat-menyurat resmi, serta melakukan koordinasi intensif antar divisi dalam menyukseskan program kerja kesiswaan.'
                    ],
                    [
                        'period' => '2023 - Sekarang',
                        'title' => 'Ketua Karang Taruna',
                        'place' => 'Warga Setempat',
                        'desc' => 'Memimpin tim pemuda dalam merancang dan mengeksekusi kegiatan sosial kemasyarakatan, mengelola logistik event desa, serta menjembatani komunikasi antarwarga.'
                    ]
                ]
            ]
        );
    }
}