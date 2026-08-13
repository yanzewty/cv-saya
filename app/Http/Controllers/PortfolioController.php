<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Message;
use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PortfolioController extends Controller
{
    private function getDefaultData()
    {
        return [
            'name'    => 'Alfiansyah Ibdani',
            'role'    => 'IT Engineering',
            'about'   => 'Siswa kelas 12 IT Engineering dengan minat mendalam di bidang pengembangan web dan desain UI/UX. Aktif berorganisasi sebagai Sekretaris Umum OSIS dan Ketua Karang Taruna untuk mengasah kepemimpinan, manajemen tim, dan komunikasi. Terbiasa memecahkan masalah teknis (troubleshooting) secara logis dan selalu antusias mengeksplorasi teknologi baru.',
            'email'   => 'yanzewty@gmail.com',
            'phone'   => '088235921495',
            'address' => 'Perumahan Palempertiwi, Menganti, Gresik',
            'skills'      => json_encode(['HTML', 'CSS', 'PHP', 'Laravel', 'UI/UX Design', 'Poster Digital', 'Troubleshooting', 'Leadership', 'Administrasi', 'Problem Solving']),
            'education'   => json_encode([
                [
                    'periode'   => 'Juli 2024 - Sekarang',
                    'instansi'  => 'SMK Negeri 1 Surabaya',
                    'jurusan'   => 'Siswa Kelas 12 - IT Engineering',
                    'deskripsi' => 'Fokus pada pemrograman web serta desain UI/UX. Saat ini saya berfokus mengembangkan wawasan yang luas mengenai pemrograman melalui kegiatan magang dan praktik industri.'
                ]
            ]),
            'experiences' => json_encode([
                [
                    'periode'   => '2025 - 2026',
                    'posisi'    => 'Sekretaris Umum OSIS',
                    'instansi'  => 'SMK Negeri 1 Surabaya',
                    'deskripsi' => 'Mengelola administrasi, persuratan, dan dokumentasi seluruh kegiatan. Berperan aktif merencanakan program kerja tahunan sekolah bersama tim.'
                ],
                [
                    'periode'   => 'Saat Ini',
                    'posisi'    => 'Ketua Karang Taruna',
                    'instansi'  => 'Menganti, Gresik',
                    'deskripsi' => 'Memimpin koordinasi pemuda-pemudi tingkat wilayah, serta merancang program sosial kemasyarakatan secara kolaboratif.'
                ]
            ]),
            'hobbies'     => json_encode(['Eksplorasi Teknologi', 'Gaming Conqueror'])
        ];
    }

    public function index()
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        
        return view('portfolio.portofolio', compact('profile'));
    }

    public function edit()
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());

        $skillsArray = json_decode($profile->skills, true);
        if (is_array($skillsArray)) {
            $profile->skills = implode(', ', $skillsArray);
        }

        $experiences = json_decode($profile->experiences, true);
        if (is_array($experiences)) {
            $profile->exp1_period = $experiences[0]['periode'] ?? '';
            $profile->exp1_title  = $experiences[0]['posisi'] ?? '';
            $profile->exp1_place  = $experiences[0]['instansi'] ?? '';
            $profile->exp1_desc   = $experiences[0]['deskripsi'] ?? '';

            $profile->exp2_period = $experiences[1]['periode'] ?? '';
            $profile->exp2_title  = $experiences[1]['posisi'] ?? '';
            $profile->exp2_place  = $experiences[1]['instansi'] ?? '';
            $profile->exp2_desc   = $experiences[1]['deskripsi'] ?? '';
        }

        return view('portfolio.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'photo'     => 'nullable|image|max:2048',
            'gallery_1' => 'nullable|image|max:2048',
            'gallery_2' => 'nullable|image|max:2048',
            'gallery_3' => 'nullable|image|max:2048',
        ], [
            'photo.max'     => 'Foto Profil terlalu besar! Maksimal 2MB.',
            'gallery_1.max' => 'Gambar Galeri 1 terlalu besar! Maksimal 2MB.',
            'gallery_2.max' => 'Gambar Galeri 2 terlalu besar! Maksimal 2MB.',
            'gallery_3.max' => 'Gambar Galeri 3 terlalu besar! Maksimal 2MB.',
            '*.image'       => 'File yang diupload harus berupa gambar.',
        ]);

        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        
        $data = $request->except([
            '_token', '_method', 'photo', 
            'gallery_1', 'gallery_2', 'gallery_3',
            'exp1_period', 'exp1_title', 'exp1_place', 'exp1_desc',
            'exp2_period', 'exp2_title', 'exp2_place', 'exp2_desc',
            'skills' 
        ]);

        if ($request->has('skills')) {
            $skillsArray = array_map('trim', explode(',', $request->skills));
            $data['skills'] = json_encode(array_filter($skillsArray));
        }

        $experiences = [
            [
                'periode'   => $request->exp1_period,
                'posisi'    => $request->exp1_title,
                'instansi'  => $request->exp1_place,
                'deskripsi' => $request->exp1_desc,
            ],
            [
                'periode'   => $request->exp2_period,
                'posisi'    => $request->exp2_title,
                'instansi'  => $request->exp2_place,
                'deskripsi' => $request->exp2_desc,
            ]
        ];
        $data['experiences'] = json_encode($experiences);

        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($request->hasFile('photo')) {
            if (!empty($profile->photo) && file_exists($uploadPath . '/' . $profile->photo)) {
                @unlink($uploadPath . '/' . $profile->photo);
            }
            $file = $request->file('photo');
            $filename = time() . '_profil_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $data['photo'] = $filename;
        }

        if ($request->hasFile('gallery_1')) {
            if (!empty($profile->gallery_1) && file_exists($uploadPath . '/' . $profile->gallery_1)) {
                @unlink($uploadPath . '/' . $profile->gallery_1);
            }
            $file = $request->file('gallery_1');
            $filename = time() . '_g1_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $data['gallery_1'] = $filename;
        }

        if ($request->hasFile('gallery_2')) {
            if (!empty($profile->gallery_2) && file_exists($uploadPath . '/' . $profile->gallery_2)) {
                @unlink($uploadPath . '/' . $profile->gallery_2);
            }
            $file = $request->file('gallery_2');
            $filename = time() . '_g2_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $data['gallery_2'] = $filename;
        }

        if ($request->hasFile('gallery_3')) {
            if (!empty($profile->gallery_3) && file_exists($uploadPath . '/' . $profile->gallery_3)) {
                @unlink($uploadPath . '/' . $profile->gallery_3);
            }
            $file = $request->file('gallery_3');
            $filename = time() . '_g3_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $data['gallery_3'] = $filename;
        }

        $profile->update($data);
        
        return redirect()->route('portofolio.index')->with('success', 'Data & Gambar berhasil diperbarui!');
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Simpan pesan ke database terlebih dahulu agar pasti aman
            Message::create([
                'name'    => $request->name,
                'email'   => $request->email,
                'message' => $request->message,
            ]);

            // Coba kirim email via SMTP secara aman (jika gagal koneksi lokal, di-bypass agar tidak error)
            try {
                Mail::to('yanzewty@gmail.com')->send(new ContactMessage($request->all()));
            } catch (\Exception $mailEx) {
                // Abaikan error email di server lokal agar form tetap sukses
            }

            return response()->json(['success' => 'Terima kasih! Pesan berhasil dikirim.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengirim pesan: ' . $e->getMessage()], 500);
        }
    }

    public function messagesAdmin()
    {
        $messages = Message::latest()->get();
        return view('portfolio.messages', compact('messages'));
    }

    public function deleteMessage($id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pesan berhasil dihapus!');
    }
}